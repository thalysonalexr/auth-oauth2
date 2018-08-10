<?php

declare(strict_types=1);

namespace App\Core\Factory;

use Psr\Container\ContainerInterface;
use App\Domain\Service\UserServiceInterface;

final class UserHandlerFactory
{
    public function __invoke(ContainerInterface $container, string $name)
    {
        return new $name(
            $container->get(UserServiceInterface::class)
        );
    }
}
