<?php

return [
    'required' => ':attribute wajib diisi.',
    'captcha' => 'Captcha tidak valid.',

    'custom' => [
        'g-recaptcha-response' => [
            'required' => 'Captcha tidak boleh kosong.',
            'captcha' => 'Captcha tidak valid.',
        ],
    ],

    'attributes' => [
        'g-recaptcha-response' => 'captcha',
    ],
];
