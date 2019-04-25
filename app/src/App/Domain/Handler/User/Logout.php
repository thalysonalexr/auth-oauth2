<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use Zend\Expressive\Router\RouterInterface;
use Zend\Diactoros\Response\RedirectResponse;
use Firebase\JWT\JWT;

final class Logout implements MiddlewareInterface
{
    /**
     * @var UserServiceInterface
     */
    private $usersService;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var string
     */
    private $jwtSecret;

    /**
     * @var array
     */
    private $jwtSession;

    public function __construct(
        UserServiceInterface $usersService,
        RouterInterface $router,
        string $jwtSecret,
        array $jwtSession
    )
    {
        $this->usersService = $usersService;
        $this->router = $router;
        $this->jwtSecret = $jwtSecret;
        $this->jwtSession = $jwtSession;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $session = $request->getAttribute('session');

        if ($session->has($this->jwtSession['session_name']) && $session->has($this->jwtSession['session_exp'])) {
            try {
                // decode a token
                $token = $session->get($this->jwtSession['session_name']);
                $jwt = JWT::decode($token, $this->jwtSecret, ['HS256']);

                $this->usersService->signout($jwt->jti);
            } catch (\Exception $e) {
                // token expires or invalid | set timeout
                $this->usersService->timeout($session->get(
                    $this->jwtSession['session_jti']
                ));
            } finally {
                // clear session
                $session->unset($this->jwtSession['session_name']);
                $session->unset($this->jwtSession['session_exp']);
                $session->unset($this->jwtSession['session_jti']);
            }
        }

        return new RedirectResponse($this->router->generateUri('home.get'), 301);
    }
}
