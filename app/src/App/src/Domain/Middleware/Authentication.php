<?php

declare(strict_types=1);

namespace App\Domain\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use App\Domain\Handler\User\Login;
use App\Domain\Documents\User;
use App\Domain\Documents\UserOauth;
use App\Domain\Service\Exception\UserNotFoundException;
use Firebase\JWT\JWT;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Router\RouterInterface;

final class Authentication implements MiddlewareInterface
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

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $session = $request->getAttribute('session');
        $message = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);

        $jwt = $session->has($this->jwtSession['session_name']) ?
               $session->get($this->jwtSession['session_name']) :
               null;

        try {
            $payload = JWT::decode($jwt, $this->jwtSecret, ['HS256'])->data;
            
            // verify user exists in database
            try {
                $user  = $this->usersService->getByEmail($payload->email, User::class);

                if ($user instanceof User) {
                    return $handler->handle($request->withAttribute(self::class, $payload));
                }
                
            } catch (UserNotFoundException $e) {

                try {
                    $user = $this->usersService->getByEmail($payload->email, UserOauth::class);

                    if ($user instanceof UserOauth) {
                        return $handler->handle($request->withAttribute(self::class, $payload));
                    }
    
                } catch (UserNotFoundException $e) {
                    $message->flash(Login::LOGGED, [
                        'logged' => false,
                        'message' => 'User not found! Please, check information'
                    ]);
    
                    return new RedirectResponse($this->router->generateUri('home.get'), 301);
                }
            }            
        } catch (\Exception $e) {
            if ($session->has($this->jwtSession['session_jti']) &&
                $session->get($this->jwtSession['session_jti'] !== null)) {

                $this->usersService->timeout($session->get(
                    $this->jwtSession['session_jti']
                ));
            }

            $message->flash(Login::LOGGED, [
                'logged' => false,
                'message' => 'Please log in to continue'
            ]);

            return new RedirectResponse($this->router->generateUri('home.get'), 301);
        }
    }
}
