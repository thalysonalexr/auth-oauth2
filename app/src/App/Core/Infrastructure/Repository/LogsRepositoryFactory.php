<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use Psr\Container\ContainerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Infrastructure\Repository\LogsRepository;

final class LogsRepositoryFactory
{
    public function __invoke(ContainerInterface $container): LogsRepository
    {
        return new LogsRepository($container->get(DocumentManager::class));
    }
}
