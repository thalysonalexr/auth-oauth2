<?php

declare(strict_types=1);

namespace App\Core\Infrastructure\Repository;

use Psr\Container\ContainerInterface;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Infrastructure\Repository\UserRepository;

final class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container): UserRepository
    {
        return new UserRepository($container->get(DocumentManager::class));
    }
}
