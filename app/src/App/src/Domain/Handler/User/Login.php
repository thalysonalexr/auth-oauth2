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
use Zend\Diactoros\Response\JsonResponse;
use Zend\Diactoros\Response\RedirectResponse;
use Zend\Expressive\Flash\FlashMessageMiddleware;
use Zend\Expressive\Router\RouterInterface;

final class Login implements MiddlewareInterface
{
    use \App\Core\Helpers\JwtWrapper;

    /**
     * @var string
     */
    const LOGGED = 'logged';

    /**
     * @var UsersServiceInterface
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
        $this->jwtSecret = $jwtSecret;
        $this->jwtSession = $jwtSession;
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler) : ResponseInterface
    {
        $data = $request->getParsedBody();
        
        $br = $request->getServerParams()['HTTP_USER_AGENT'];
        $ip = $request->getAttribute('_ip');

        try {
            $user = $this->usersService->getByEmail($data['email'], User::class);
        } catch (UserNotFoundException $e) {
            return new JsonResponse([
                'code' => '401',
                'message' => $e->getMessage()
            ], 401);
        }

        try {
           Password::verify($data['password'], $user->getPassword());
        } catch (WrongPasswordException $e) {
            $this->usersService->createLog($user, $br, $ip, false);
            return new JsonResponse([
                'code' => '401',
                'message' => $e->getMessage()
            ], 401);
        }

        // log success
        $this->usersService->createLog($user, $br, $ip, true);
        
        $jwt = $this->createJwt($user);

        $session = $request->getAttribute('session');

        $session->set($this->jwtSession['session_exp'], $jwt->exp);
        $session->set($this->jwtSession['session_name'], $jwt->token);

        $flashMessages = $request->getAttribute(FlashMessageMiddleware::FLASH_ATTRIBUTE);
        $flashMessages->flash(self::LOGGED, [
            'logged' => true,
            'message' => 'Login successfully, you are on your profile!'
        ]);

        return new RedirectResponse($this->router->generateUri('profile.get'), 301);
    }
}
