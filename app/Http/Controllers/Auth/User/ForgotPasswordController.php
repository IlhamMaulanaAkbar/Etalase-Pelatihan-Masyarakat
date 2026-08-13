<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Mail\UserPasswordResetMail;
use App\Models\User;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Throwable;

class ForgotPasswordController extends Controller
{
    public function request()
    {
        return view('auth.user.forgot-password');
    }

    public function email(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $user = User::where('email', $request->email)
            ->where('role', 'user')
            ->first();

        if ($user) {
            $plainToken = Str::random(64);

            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $user->email],
                [
                    'token' => Hash::make($plainToken),
                    'created_at' => now(),
                ]
            );

            try {
                Mail::to($user->email)->send(
                    new UserPasswordResetMail($user, route('password.reset', [
                        'token' => $plainToken,
                        'email' => $user->email,
                    ]))
                );
            } catch (Throwable $exception) {
                report($exception);
                Alert::error('Email reset password gagal dikirim. Silakan coba lagi nanti.');

                return back()->withInput();
            }
        }

        Alert::success('Jika email terdaftar, link reset password telah dikirim.');

        return back();
    }

    public function reset(Request $request, string $token)
    {
        return view('auth.user.reset-password', [
            'token' => $token,
            'email' => $request->query('email'),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
            'password.confirmed' => 'Konfirmasi password tidak sesuai.',
            'password.min' => 'Password wajib minimal 8 karakter.',
        ]);

        $reset = DB::table('password_reset_tokens')
            ->where('email', $validated['email'])
            ->first();

        if (! $reset || ! Hash::check($validated['token'], $reset->token)) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        if (Carbon::parse($reset->created_at)->lt(now()->subMinutes(60))) {
            DB::table('password_reset_tokens')->where('email', $validated['email'])->delete();

            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Token reset password sudah kedaluwarsa.']);
        }

        $user = User::where('email', $validated['email'])
            ->where('role', 'user')
            ->firstOrFail();

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        Alert::success('Password berhasil direset. Silakan login menggunakan password baru.');

        return redirect()->route('auth.user.login.index');
    }
}
