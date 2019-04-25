<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\MiddlewareFactory;

/**
 * Setup routes with a single request method:
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {

    $app->post('/login', \App\Domain\Handler\User\Login::class, 'login.post');

    $app->post('/logout', \App\Domain\Handler\User\Logout::class, 'logout.post');

    $app->get('/login/facebook/callback', [
        \App\Domain\Handler\User\LoginCallbackFacebook::class,
        \App\Domain\Handler\User\CreateOauth::class
    ], 'login-facebook-callback.get');

    $app->get('/login/google/callback', [
        \App\Domain\Handler\User\LoginCallbackGoogle::class,
        \App\Domain\Handler\User\CreateOauth::class
    ], 'login-google-callback.get');

    $app->post('/register', \App\Domain\Handler\User\Create::class, 'register.post');

    // pages
    $app->get('/', [
        \App\Domain\Handler\User\LoginFacebook::class,
        \App\Domain\Handler\User\LoginGoogle::class,
        \App\Handler\HomePageHandler::class
    ], 'home.get');

    $app->get('/api/ping', \App\Handler\PingHandler::class, 'api.ping');

    $app->get('/profile', [
        \App\Domain\Middleware\Authentication::class,
        \App\Handler\User\ProfileHandler::class
    ], 'profile.get');
};
