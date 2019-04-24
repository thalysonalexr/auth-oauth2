<?php

declare(strict_types=1);

return [
    'dependencies' => [
        'factories'  => [
            // \Middlewares\HttpAuthentication::class => \App\Core\Middleware\JwtAuthenticationFactory::class,
            \App\Domain\Middleware\Authentication::class => \App\Core\Factory\UserAuthHandlerFactory::class,
            \Middlewares\AccessLog::class => \App\Core\Middleware\AccessLogFactory::class,
        ],
    ],
];
