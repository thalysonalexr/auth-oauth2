<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Logout implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $jwtSession;

    public function __construct(array $jwtSession)
    {
        $this->jwtSession = $jwtSession;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $session = $request->getAttribute('session');

        var_dump($session);exit;
    }
}
