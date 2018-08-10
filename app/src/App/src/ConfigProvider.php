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
            'invokables' => [
                Handler\PingHandler::class => Handler\PingHandler::class,
            ],
            'factories'  => [
                // homepage
                Handler\HomePageHandler::class => Handler\HomePageHandlerFactory::class,

                // connection
                \Doctrine\ODM\MongoDB\DocumentManager::class => \App\Core\Factory\DocumentManagerFactory::class,

                // actions
                \App\Domain\Handler\User\Create::class => \App\Core\Factory\UserHandlerFactory::class,

                // service
                \App\Domain\Service\UserServiceInterface::class => \App\Core\Domain\Service\UserServiceFactory::class,

                // repository
                \App\Infrastructure\Repository\UserRepositoryInterface::class => \App\Core\Infrastructure\Repository\UserRepositoryFactory::class,
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
                'error'  => [__DIR__ . '/../templates/error'],
                'layout' => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }
}
