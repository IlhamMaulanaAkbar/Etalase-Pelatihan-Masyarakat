<?php

namespace App\Http\Controllers\Auth\User;

use App\Http\Controllers\Controller;
use App\Mail\UserEmailVerificationMail;
use App\Models\User;
use App\Services\Supports\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Throwable;

class EmailVerificationController extends Controller
{
    public function notice(Request $request)
    {
        if ($request->user('user')->email_verified_at) {
            return redirect()->route('public.home.dashboard.index');
        }

        return view('auth.user.verify-email');
    }

    public function send(Request $request)
    {
        $user = $request->user('user');

        if ($user->email_verified_at) {
            return redirect()->route('public.home.dashboard.index');
        }

        try {
            Mail::to($user->email)->send(
                new UserEmailVerificationMail($user, $this->verificationUrl($user))
            );
        } catch (Throwable $exception) {
            report($exception);

            Alert::error('Link verifikasi gagal dikirim. Silakan periksa konfigurasi email atau coba lagi nanti.');

            return back();
        }

        Alert::success('Link verifikasi baru telah dikirim ke email Anda.');

        return back();
    }

    public function verify(Request $request, int $id, string $hash)
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Link verifikasi tidak valid atau sudah kedaluwarsa.');
        }

        if ((int) $request->user('user')->id !== $id) {
            abort(403, 'Akun yang sedang login tidak sesuai dengan link verifikasi.');
        }

        $user = User::findOrFail($id);

        if (! hash_equals((string) $hash, sha1($user->email))) {
            abort(403, 'Link verifikasi tidak valid.');
        }

        if (! $user->email_verified_at) {
            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();
        }

        Alert::success('Email berhasil diverifikasi.');

        return redirect()->route('public.home.dashboard.index');
    }

    private function verificationUrl(User $user): string
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );
    }
}
