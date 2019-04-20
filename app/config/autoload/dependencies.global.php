<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'aliases' => [
        ],
        'invokables' => [
        ],
        'factories'  => [
            // \Middlewares\HttpAuthentication::class => \App\Core\Middleware\JwtAuthenticationFactory::class,
            \App\Domain\Middleware\Authentication::class => \App\Core\Middleware\AuthenticationFactory::class,
            \Middlewares\AccessLog::class => \App\Core\Middleware\AccessLogFactory::class,
        ],
    ],
];
