<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    
    // actions
    $app->post('/login', \App\Domain\Handler\User\Login::class, 'login.post');
    $app->post('/register', \App\Domain\Handler\User\Create::class, 'register.post');

    // pages
    $app->get('/', \App\Handler\HomePageHandler::class, 'home');
    $app->get('/api/ping', \App\Handler\PingHandler::class, 'api.ping');
    $app->get('/profile', [
        \App\Domain\Middleware\Authentication::class,
        //\Middlewares\HttpAuthentication::class,
        \App\Handler\User\ProfileHandler::class
    ], 'profile.get');
};
