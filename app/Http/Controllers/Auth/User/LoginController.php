<?php

namespace App\Http\Controllers\Auth\User;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\Supports\Alert;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.user.login.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        if ($validator->fails()) {
            // Alert::error('Validasi gagal. Pastikan captcha sudah dicentang.');
            return back()->withErrors($validator)->withInput();
        }
        $credentials = $request->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            // Cek role setelah login berhasil
            if (auth('user')->user()->role !== 'user') {
                Auth::guard('user')->logout(); // logout langsung
                Alert::error('Anda tidak memiliki akses.');
                return back();
            }

            $request->session()->regenerate();

            Alert::success('Selamat datang, ' . auth('user')->user()->name . '.');
            return redirect()->intended(route('public.home.dashboard.index', absolute: false));
        } else {
            Alert::error('Email atau password salah.');
            return back();
        }
    }



    public function oAuthRedirect($provider)
    {
        if ($provider === 'google') {
            config()->set('services.google.redirect', config('services.google.user_login_redirect'));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function connectOAuthRedirect($provider)
    {
        if ($provider === 'google') {
            config()->set('services.google.redirect', route('auth.user.oauth.connect.callback', [
                'provider' => $provider,
            ]));
        }

        return Socialite::driver($provider)->redirect();
    }

    public function oAuthCallback($provider, Request $request)
    {
        if ($provider === 'google') {
            config()->set('services.google.redirect', config('services.google.user_login_redirect'));
        }

        $oAuthUser = Socialite::driver($provider)->user();
        $oAuthId = $oAuthUser->getId();

        // cari user berdasarkan provider
        $user = User::where([
            'oauth_provider' => $provider,
            'oauth_provider_id' => $oAuthId,
        ])->first();

        if (!$user) {
            // cek email sudah ada atau belum
            $user = User::where('email', $oAuthUser->getEmail())->first();

            if ($user) {
                Alert::error('Email ' . $oAuthUser->getEmail() . ' sudah terdaftar melalui pendaftaran manual. Silakan login menggunakan email dan password.');
                return redirect()->route('auth.user.login.index');
            } else {
                // buat user baru
                $user = new User();
                $user->oauth_provider = $provider;
                $user->oauth_provider_id = $oAuthId;
                $user->name = $oAuthUser->getName();
                $user->email = $oAuthUser->getEmail();
                $user->email_verified_at = now();
                $user->password = Hash::make($request->password); // Kosongkan password karena login menggunakan OAuth
                $user->role = 'user';
                $user->save();
            }
        }


        auth('user')->login($user);

        Alert::success('Selamat datang, ' . auth('user')->user()->name . '.');
        return redirect()->intended(route('public.home.dashboard.index'));
    }

    public function connectOAuthCallback($provider)
    {
        if ($provider === 'google') {
            config()->set('services.google.redirect', route('auth.user.oauth.connect.callback', [
                'provider' => $provider,
            ]));
        }

        $oAuthUser = Socialite::driver($provider)->user();
        $oAuthId = $oAuthUser->getId();
        $user = auth('user')->user();

        $usedByAnotherUser = User::where('oauth_provider', $provider)
            ->where('oauth_provider_id', $oAuthId)
            ->where('id', '!=', $user->id)
            ->exists();

        if ($usedByAnotherUser) {
            Alert::error('Akun Google tersebut sudah terhubung dengan akun lain.');
            return redirect()
                ->route('public.account.profile.index')
                ->with('active_tab', 'settings');
        }

        $user->forceFill([
            'oauth_provider' => $provider,
            'oauth_provider_id' => $oAuthId,
            'email_verified_at' => $user->email === $oAuthUser->getEmail()
                ? ($user->email_verified_at ?? now())
                : $user->email_verified_at,
        ])->save();

        Alert::success('Akun Google berhasil dihubungkan.');

        return redirect()
            ->route('public.account.profile.index')
            ->with('active_tab', 'settings');
    }

    public function disconnectOAuth($provider)
    {
        $user = auth('user')->user();

        if ($user->oauth_provider !== $provider) {
            Alert::warning('Akun tersebut belum terhubung.');
            return back()->with('active_tab', 'settings');
        }

        $user->forceFill([
            'oauth_provider' => null,
            'oauth_provider_id' => null,
        ])->save();

        Alert::success('Akun Google berhasil diputuskan.');

        return redirect()
            ->route('public.account.profile.index')
            ->with('active_tab', 'settings');
    }

    public function destroy(Request $request)
    {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        Alert::success('Anda telah berhasil keluar.');
        return redirect()->route('auth.user.login.index');
    }
}
