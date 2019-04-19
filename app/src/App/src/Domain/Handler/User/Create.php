<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Domain\Service\UserServiceInterface;
use App\Domain\Service\Exception\UserEmailExistsException;
use Zend\Diactoros\Response\JsonResponse;

final class Create implements MiddlewareInterface
{
    /**
     * @var UserServiceInterface
     */
    private $usersService;

    public function __construct(UserServiceInterface $usersService)
    {
        $this->usersService = $usersService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $body = $request->getParsedBody();

        try {
            $success = $this->usersService->create(
                $body['name'],
                $body['email'],
                $body['password']
            );
        } catch (UserEmailExistsException $e) {
            return new JsonResponse([
                'code' => 400,
                'message' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'success' => $success
        ], 201);
    }
}
