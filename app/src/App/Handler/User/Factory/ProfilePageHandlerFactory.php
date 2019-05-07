<?php

declare(strict_types=1);

namespace App\Handler\User\Factory;

use Psr\Container\ContainerInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Handler\User\ProfileHandler;
use Zend\Expressive\Template\TemplateRendererInterface;

class ProfileHandlerFactory
{
    public function __invoke(ContainerInterface $container): RequestHandlerInterface
    {
        $template = $container->has(TemplateRendererInterface::class)
            ? $container->get(TemplateRendererInterface::class)
            : null;

        return new ProfileHandler($template);
    }
}
