<?php

$allowedHostnames = array_filter(array_map(
    'trim',
    explode(',', (string) env('NOCAPTCHA_ALLOWED_HOSTNAMES', ''))
));

return [
    'sitekey' => env('NOCAPTCHA_SITEKEY'),
    'secret' => env('NOCAPTCHA_SECRET'),

    // recaptcha.net is Google's supported alternative when google.com is not
    // reachable from a browser or hosting environment.
    'client_url' => env(
        'NOCAPTCHA_CLIENT_URL',
        'https://www.recaptcha.net/recaptcha/api.js'
    ),
    'verify_url' => env(
        'NOCAPTCHA_VERIFY_URL',
        'https://www.recaptcha.net/recaptcha/api/siteverify'
    ),

    'timeout' => (int) env('NOCAPTCHA_TIMEOUT', 10),
    'connect_timeout' => (int) env('NOCAPTCHA_CONNECT_TIMEOUT', 5),
    'allowed_hostnames' => array_values($allowedHostnames),

    // Retained for compatibility with anhskohbo/no-captcha while other parts
    // of the application still have the package installed.
    'options' => [
        'timeout' => (int) env('NOCAPTCHA_TIMEOUT', 10),
        'connect_timeout' => (int) env('NOCAPTCHA_CONNECT_TIMEOUT', 5),
    ],
];
