<?php

declare(strict_types=1);

use Psr\Container\ContainerInterface;
use Zend\Expressive\Application;
use Zend\Expressive\Handler\NotFoundHandler;
use Zend\Expressive\Helper\ServerUrlMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use Zend\Expressive\MiddlewareFactory;
use Zend\Expressive\Router\Middleware\DispatchMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitHeadMiddleware;
use Zend\Expressive\Router\Middleware\ImplicitOptionsMiddleware;
use Zend\Expressive\Router\Middleware\MethodNotAllowedMiddleware;
use Zend\Expressive\Router\Middleware\RouteMiddleware;
use Zend\Stratigility\Middleware\ErrorHandler;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;

/**
 * Setup middleware pipeline:
 */
return function (Application $app, MiddlewareFactory $factory, ContainerInterface $container) : void {
    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe((new \Middlewares\ClientIp())->attribute('_ip'));
    $app->pipe(\Middlewares\AccessLog::class);
    //$app->pipe((new Middlewares\Https())->includeSubdomains());
    $app->pipe(new Middlewares\Www(false));
    $app->pipe(RouteMiddleware::class);
    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);
    $app->pipe(UrlHelperMiddleware::class);
    $app->pipe(\Zend\Expressive\Session\SessionMiddleware::class);
    $app->pipe(\Zend\Expressive\Flash\FlashMessageMiddleware::class);
    $app->pipe(BodyParamsMiddleware::class);
    $app->pipe(new Middlewares\CssMinifier());
    $app->pipe(new Middlewares\JsMinifier());
    $app->pipe(new Middlewares\HtmlMinifier());
    $app->pipe(new Middlewares\ContentLength());
    $app->pipe(DispatchMiddleware::class);
    $app->pipe(NotFoundHandler::class);
};
