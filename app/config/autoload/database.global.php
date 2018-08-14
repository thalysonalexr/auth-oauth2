<?php

declare(strict_types=1);

return [
    'doctrine' => [
        'connection' => [
            'default' => [
                'db_name' => 'login_facebook',
                'db_host' => 'mongodb',
                'proxies_dir' => '/tmp/Proxies',
                'proxies_namespace' => 'Proxies',
                'hydrators_dir' => '/tmp/Hydrators',
                'hydrators_namespace' => 'Hydrators',
                'documents_dir' => __DIR__ . '/../../src/App/src/Domain/Documents',
            ],
        ],
    ],
];
