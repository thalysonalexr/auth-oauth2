<?php

declare(strict_types=1);

namespace App\Core\Domain\Service;

use Psr\Container\ContainerInterface;
use App\Domain\Service\LogsService;
use App\Infrastructure\Repository\LogsRepositoryInterface;

final class LogsServiceFactory
{
    public function __invoke(ContainerInterface $container): LogsService
    {
        return new LogsService($container->get(LogsRepositoryInterface::class));
    }
}
