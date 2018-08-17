<?php

declare(strict_types=1);

namespace App\Core\Factory;

use App\Domain\Service\UserServiceInterface;
use App\Domain\Handler\User\Login;
use Psr\Container\ContainerInterface;

final class UserAuthHandlerFactory
{
    public function __invoke(ContainerInterface $container): Login
    {
        return new Login(
            $container->get(UserServiceInterface::class),
            $container->get('config')['jwt']['secret']
        );
    }
}
