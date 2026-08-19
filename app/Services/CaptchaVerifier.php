<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CaptchaVerifier
{
    public function verify(string $token, ?string $clientIp = null): bool
    {
        $secret = (string) config('captcha.secret');

        if ($token === '' || $secret === '') {
            return false;
        }

        $response = Http::asForm()
            ->acceptJson()
            ->connectTimeout((int) config('captcha.connect_timeout', 5))
            ->timeout((int) config('captcha.timeout', 10))
            ->post((string) config('captcha.verify_url'), array_filter([
                'secret' => $secret,
                'response' => $token,
                'remoteip' => $clientIp,
            ], static fn ($value) => $value !== null && $value !== ''));

        if (! $response->successful()) {
            Log::warning('Captcha verification returned an HTTP error.', [
                'status' => $response->status(),
            ]);

            return false;
        }

        $result = $response->json();

        if (! is_array($result) || ($result['success'] ?? false) !== true) {
            Log::info('Captcha verification was rejected.', [
                'error_codes' => $result['error-codes'] ?? [],
            ]);

            return false;
        }

        return $this->hostnameIsAllowed($result['hostname'] ?? null);
    }

    private function hostnameIsAllowed(mixed $hostname): bool
    {
        $allowedHostnames = config('captcha.allowed_hostnames', []);

        if ($allowedHostnames === []) {
            return true;
        }

        if (! is_string($hostname) || $hostname === '') {
            return false;
        }

        return in_array(strtolower($hostname), array_map(
            static fn ($allowedHostname) => strtolower((string) $allowedHostname),
            $allowedHostnames
        ), true);
    }
}
