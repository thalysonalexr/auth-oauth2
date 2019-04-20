<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use Psr\Container\ContainerInterface;
use App\Domain\Middleware\Authentication;
use App\Domain\Service\UserServiceInterface;

class AuthenticationFactory
{
    public function __invoke(ContainerInterface $container): Authentication
    {
        return new Authentication(
            $container->get('config')['session']['jwt'],
            $container->get('config')['auth']['jwt']['secret'],
            $container->get(UserServiceInterface::class)
        );
    }
}
