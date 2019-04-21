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
use App\Domain\Documents\UserOauth;
use Tuupola\Base62;
use Firebase\JWT\JWT;

final class CreateOauth implements MiddlewareInterface
{
    /**
     * @var UserServiceInterface
     */
    private $usersService;

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
        string $jwtSecret,
        array $jwtSession
    )
    {
        $this->usersService = $usersService;
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
            $future = new \DateTime('+20 minutes');

            $payload = [
                'iat' => (new \DateTime())->getTimestamp(),
                'exp' => $future->getTimestamp(),
                'jti' => (new Base62)->encode(random_bytes(16)),
                'data' => [
                    'id' => (string) $user->getId()->__toString(),
                    'name' => $user->getName()->__toString(),
                    'email' => $user->getEmail()->__toString()
                ]
            ];

            $token = JWT::encode($payload, $this->jwtSecret, 'HS256');
            $session = $request->getAttribute('session');

            $session->set($this->jwtSession['session_name'], $token);
            $session->set($this->jwtSession['session_exp'], $future);

            $this->usersService->createLog($user, $br, $ip, true);
            return new RedirectResponse('/profile', 301);
        }
    }
}
