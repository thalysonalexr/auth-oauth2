<?php

declare(strict_types=1);

namespace App\Core\Domain\Service;

use Psr\Container\ContainerInterface;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\UserRepositoryInterface;

final class UserServiceFactory
{
    public function __invoke(ContainerInterface $container): UserService
    {
        return new UserService($container->get(UserRepositoryInterface::class));
    }
}
