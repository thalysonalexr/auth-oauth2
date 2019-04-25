<?php

declare(strict_types=1);

namespace App\Core\Domain\Service\Google;

use Psr\Container\ContainerInterface;
use Zend\Expressive\Router\RouterInterface;
use App\Core\Helpers\Server;
use League\OAuth2\Client\Provider\Google;

final class ProviderFactory extends Server
{
    public function __invoke(ContainerInterface $container): Google
    {
        $router = $container->get(RouterInterface::class);
        $config = $container->get('config')['oauth2']['google'];

        $gConfig = [
            'clientId'        => $config['id_app'],
            'clientSecret'    => $config['secret'],
            'redirectUri'     => $this->serverWithUri($router->generateUri($config['redirect_uri']))
        ];

        if ($config['hostedDomain']['enabled']) {
            $gConfig['hostedDomain'] = $config['hostedDomain']['domain'];
        }

        return new Google($gConfig);
    }
}