<?php

declare(strict_types=1);

return [
    'doctrine' => [
        'connection' => [
            'default' => [
                'db_name' => 'auth_oauth2',
                'db_host' => 'mongodb',
                'db_port' => 27017,
                'proxies_dir' => '/tmp/Proxies',
                'proxies_namespace' => 'Proxies',
                'hydrators_dir' => '/tmp/Hydrators',
                'hydrators_namespace' => 'Hydrators',
                'documents_dir' => __DIR__ . '/../../src/App/src/Domain/Documents',
            ],
        ],
    ],
];
