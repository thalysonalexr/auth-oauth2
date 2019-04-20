<?php

declare(strict_types=1);

return [
    'session' => [
        'jwt' => [
            'cookie_name' => '_sessusertoken',
            'cookie_secure' => false,
            'expires_time' => 1200, // 20 minutes,
            'domain' => ''
        ]
    ]
];
