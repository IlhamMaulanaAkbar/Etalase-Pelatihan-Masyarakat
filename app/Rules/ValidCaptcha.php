<?php

namespace App\Rules;

use App\Services\CaptchaVerifier;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Log;

class ValidCaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! filled(config('captcha.sitekey')) || ! filled(config('captcha.secret'))) {
            Log::error('Captcha credentials are not configured.');
            $fail('Layanan captcha belum dikonfigurasi. Silakan hubungi administrator.');

            return;
        }

        try {
            $isValid = app(CaptchaVerifier::class)->verify(
                (string) $value,
                request()->ip()
            );
        } catch (ConnectionException $exception) {
            report($exception);
            $fail('Layanan captcha sedang tidak dapat dihubungi. Silakan coba lagi.');

            return;
        }

        if (! $isValid) {
            $fail('Captcha tidak valid atau sudah kedaluwarsa. Silakan coba lagi.');
        }
    }
}
