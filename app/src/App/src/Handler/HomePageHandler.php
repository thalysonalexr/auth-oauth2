<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Expressive\Template\TemplateRendererInterface;
use App\Domain\Handler\User\LoginFacebook;
use App\Domain\Handler\User\LoginGoogle;

class HomePageHandler implements RequestHandlerInterface
{
    /**
     * @var TemplateRendererInterface
     */
    private $template;

    public function __construct(TemplateRendererInterface $template)
    {
        $this->template = $template;
    }

    public function handle(ServerRequestInterface $request) : ResponseInterface
    {
        $fb = $request->getAttribute(LoginFacebook::class);
        $gg = $request->getAttribute(LoginGoogle::class);

        $data = [
            'facebook' => $fb,
            'google' => $gg
        ];

        return new HtmlResponse($this->template->render('app::home-page', $data));
    }
}
