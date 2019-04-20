<?php

declare(strict_types=1);

namespace App\Domain\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use Firebase\JWT\JWT;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use App\Domain\Handler\User\Login;

final class Authentication implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $session;

    /**
     * @var string
     */
    private $jwtSecret;

    /**
     * @var UserServiceInterface
     */
    private $usersService;

    public function __construct(
        array $session,
        string $jwtSecret,
        UserServiceInterface $usersService)
    {
        $this->session = $session;
        $this->jwtSecret = $jwtSecret;
        $this->usersService = $usersService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $cookies = $request->getCookieParams();
        $cookie_name = $this->session['cookie_name'];

        $token = isset($cookies[$cookie_name]) && ! empty($cookies[$cookie_name]) ? $cookies[$cookie_name] : null;

        try {
            $payload = JWT::decode($token, $this->jwtSecret, ['HS256']);
        } catch(\Exception $e) {
            $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
            $flashMessages->flash(Login::LOGGED, [
                'logged' => false,
                'message' => 'Please log in to continue'
            ]);

            return new RedirectResponse('/', 301);
        }

        return $handler->handle($request->withAttribute(self::class, $payload));
    }
}
