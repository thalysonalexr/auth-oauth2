<?php

declare(strict_types=1);

namespace App;

/**
 * The configuration provider for the App module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     *
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'aliases' => [
                \App\Domain\Service\Facebook\ProviderInterface::class => \League\OAuth2\Client\Provider\Facebook::class
            ],
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                // homepage
                \App\Handler\HomePageHandler::class => \App\Handler\HomePageHandlerFactory::class,
                \App\Handler\User\ProfileHandler::class => \App\Handler\User\Factory\ProfileHandlerFactory::class,

                // connection
                \Doctrine\ODM\MongoDB\DocumentManager::class => \App\Core\Factory\DocumentManagerFactory::class,

                // actions
                \App\Domain\Handler\User\Create::class => \App\Core\Factory\UserHandlerFactory::class,
                \App\Domain\Handler\User\CreateOauth::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\Login::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\Logout::class => \App\Core\Factory\UserAuthHandlerFactory::class,
                \App\Domain\Handler\User\LoginFacebook::class => \App\Core\Factory\UserAuthHandlerFacebookFactory::class,
                \App\Domain\Handler\User\LoginCallbackFacebook::class => \App\Core\Factory\UserAuthHandlerFacebookFactory::class,

                // service
                \App\Domain\Service\UserServiceInterface::class => \App\Core\Domain\Service\UserServiceFactory::class,
                \League\OAuth2\Client\Provider\Facebook::class => \App\Core\Domain\Service\Facebook\ProviderFactory::class,

                // repository
                \App\Infrastructure\Repository\UserRepositoryInterface::class => \App\Core\Infrastructure\Repository\UserRepositoryFactory::class,

                // middlewares
                \Middlewares\HttpAuthentication::class => \App\Core\Middleware\JwtAuthenticationFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'app'    => [__DIR__ . '/../templates/app'],
                'user'   => [__DIR__ . '/../templates/user'],
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
