<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use App\Domain\Service\Exception\UserOauthExistsException;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Router\RouterInterface;
use App\Domain\Documents\UserOauth;

final class CreateOauth implements MiddlewareInterface
{
    use \App\Core\Helpers\JwtWrapper;

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
        $body = $request->getParsedBody();

        $br = $request->getServerParams()['HTTP_USER_AGENT'];
        $ip = $request->getAttribute('_ip');

        try {
            $user = $this->usersService->createOauth(
                $body['provider'],
                $body['user_id'],
                $body['name'],
                $body['email'],
                isset($body['picture']) ? $body['picture']: null
            );
        } catch (UserOauthExistsException $e) {
            $user = $this->usersService->getByOauth(
                $body['provider'],
                $body['user_id'],
                $body['email']
            );
        } finally {
            // create a token to user and redirect to profile
            $jwt = $this->createJwt($user);

            $session = $request->getAttribute('session');

            $session->set($this->jwtSession['session_jti'], $jwt->jti);
            $session->set($this->jwtSession['session_exp'], $jwt->exp);
            $session->set($this->jwtSession['session_name'], $jwt->token);

            $this->usersService->createLog($user, $br, $ip, $jwt->jti, true);

            return new RedirectResponse($this->router->generateUri('profile.get'), 301);
        }
    }
}
