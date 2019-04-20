<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use App\Domain\Service\Exception\UserNotFoundException;
use App\Domain\Documents\User;
use App\Domain\Value\Password;
use App\Domain\Value\Exception\WrongPasswordException;
use Tuupola\Base62;
use Firebase\JWT\JWT;
use Zend\Diactoros\Response\JsonResponse;

use function random_bytes;

final class Login implements MiddlewareInterface
{
    /**
     * @var UsersServiceInterface
     */
    private $usersService;
    /**
     * @var string
     */
    private $jwtSecret;

    public function __construct(UserServiceInterface $usersService, string $jwtSecret)
    {
        $this->usersService = $usersService;
        $this->jwtSecret = $jwtSecret;
    }
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $data = $request->getParsedBody();

        try {
            $user = $this->usersService->getByEmail($data['email']);
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'code' => '401',
                'message' => $e->getMessage()
            ], 401);
        }

        try {
           Password::verify($data['password'], $user->getPassword());
        } catch (WrongPasswordException $e) {
            // log failed
            return new JsonResponse([
                'code' => '401',
                'message' => $e->getMessage()
            ], 401);
        }

        // log success
        $future = new \DateTime('+60 minutes');

        $payload = [
            'iat' => (new \DateTime())->getTimestamp(),
            'exp' => $future->getTimestamp(),
            'jti' => (new Base62)->encode(random_bytes(16)),
            'data' => [
                'id' => (string) $user->getId()->__toString(),
                'email' => $user->getEmail()->__toString()
            ]
        ];

        $token = JWT::encode($payload, $this->jwtSecret, 'HS256');

        return new JsonResponse([
            'token' => $token,
            'expires' => $future->getTimestamp()
        ]);
    }
}
