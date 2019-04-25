<?php

declare(strict_types=1);

namespace App\Core\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\MiddlewareInterface;
use Zend\Expressive\Router\RouterInterface;

final class UserAuthHandlerProviderFactory
{
    public function __invoke(ContainerInterface $container, string $className): MiddlewareInterface
    {
        if ($className::ROUTER)
            $router = $container->get(RouterInterface::class);

        return new $className($container->get($className::PROVIDER), $router ?: null);
    }
}
