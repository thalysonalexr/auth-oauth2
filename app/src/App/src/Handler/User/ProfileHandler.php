<?php

declare(strict_types=1);

namespace App\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use App\Domain\Handler\User\Login;
use Zend\Diactoros\Response\RedirectResponse;

class ProfileHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $template;

    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $messages = $flashMessages->getFlash(Login::LOGGED);

        return new HtmlResponse($this->template->render('user::profile', $messages));
    }
}
