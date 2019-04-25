<?php

declare(strict_types=1);

namespace App\Core\Factory;

use Psr\Container\ContainerInterface;
use App\Domain\Service\UserServiceInterface;

final class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $className)
    {
        return new $className(
            $container->get(UserServiceInterface::class)
        );
    }
}
