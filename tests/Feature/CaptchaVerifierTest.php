<?php

namespace Tests\Feature;

use App\Services\CaptchaVerifier;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class CaptchaVerifierTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config()->set('captcha.secret', 'test-secret');
        config()->set('captcha.verify_url', 'https://www.recaptcha.net/recaptcha/api/siteverify');
        config()->set('captcha.allowed_hostnames', []);
    }

    public function test_it_accepts_a_successful_captcha_response(): void
    {
        Http::fake([
            'www.recaptcha.net/*' => Http::response([
                'success' => true,
                'hostname' => 'my-app.wasmer.app',
            ]),
        ]);

        $this->assertTrue(app(CaptchaVerifier::class)->verify('valid-token', '127.0.0.1'));

        Http::assertSent(fn ($request) => $request->isForm()
            && $request['secret'] === 'test-secret'
            && $request['response'] === 'valid-token'
            && $request['remoteip'] === '127.0.0.1'
        );
    }

    public function test_it_rejects_an_unsuccessful_captcha_response(): void
    {
        Http::fake([
            'www.recaptcha.net/*' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ]),
        ]);

        $this->assertFalse(app(CaptchaVerifier::class)->verify('invalid-token'));
    }

    public function test_it_can_restrict_the_verified_hostname(): void
    {
        config()->set('captcha.allowed_hostnames', ['my-app.wasmer.app']);

        Http::fake([
            'www.recaptcha.net/*' => Http::response([
                'success' => true,
                'hostname' => 'attacker.example',
            ]),
        ]);

        $this->assertFalse(app(CaptchaVerifier::class)->verify('valid-token'));
    }

    public function test_it_rejects_an_http_error(): void
    {
        Http::fake([
            'www.recaptcha.net/*' => Http::response([], 503),
        ]);

        $this->assertFalse(app(CaptchaVerifier::class)->verify('valid-token'));
    }
}
