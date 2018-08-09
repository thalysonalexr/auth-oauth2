<?php

declare(strict_types=1);

return [
    'doctrine' => [
        'connection' => [
            'default' => [
                'proxies_dir' => __DIR__ . '/../../data/proxies',
                'proxies_namespace' => 'Proxies',
                'hydrators_dir' => __DIR__ . '/../../data/hydrators',
                'hydrators_namespace' => 'Hydrators',
                'documents_dir' => __DIR__ . '/../../src/App/src/Domain/Documents',
            ],
        ],
    ],
];
