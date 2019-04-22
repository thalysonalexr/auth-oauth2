<?php

declare(strict_types=1);

namespace App\Core\Domain\Service\Facebook;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Core\Helpers\Server;
use League\OAuth2\Client\Provider\Facebook;

final class ProviderFactory extends Server
{
    public function __invoke(ContainerInterface $container): Facebook
    {
        $router = $container->get(RouterInterface::class);
        $config = $container->get('config')['oauth2']['facebook'];

        return new Facebook([
            'clientId'        => $config['id_app'],
            'clientSecret'    => $config['secret'],
            'redirectUri'     => $this->serverWithUri($router->generateUri($config['redirect_uri'])),
            'graphApiVersion' => $config['version']
        ]);
    }
}