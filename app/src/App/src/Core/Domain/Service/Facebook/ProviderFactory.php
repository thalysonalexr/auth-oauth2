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
        $configFacebook = $container->get('config')['oauth2']['facebook'];

        $uri = $router->generateUri($configFacebook['redirect_uri']);

        return new Facebook([
            'clientId' => $configFacebook['id_app'],
            'clientSecret' => $configFacebook['secret'],
            'redirectUri' => $this->serverWithUri($uri),
            'graphApiVersion' => $configFacebook['version']
        ]);
    }
}