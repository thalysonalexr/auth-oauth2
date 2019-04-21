<?php

declare(strict_types=1);

namespace App\Domain\Handler\User;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use League\OAuth2\Client\Provider\Facebook;
use Zend\Diactoros\Response\RedirectResponse;
use App\Domain\Service\Facebook as Fb;

final class LoginCallbackFacebook implements MiddlewareInterface
{
    /**
     * @var Facebook
     */
    private $provider;

    public function __construct(Facebook $provider)
    {
        $this->provider = $provider;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getQueryParams();

        try {
            $token = $this->provider->getAccessToken('authorization_code', [
                'code' => $params['code']
            ]);
        } catch (League\OAuth2\Client\Provider\Exception\IdentityProviderException $e) {
            // verify token on session and redirect to profile
            if ($request->getAttribute('session')->has('oauth2state')) {
                return new RedirectResponse('/profile', 301);
            }

        } catch (\Exception $e) {
           return new RedirectResponse('/', 301);
        }

        try {
            $user = $this->provider->getResourceOwner($token);

            // persist data if never registered
            return $handler->handle($request->withParsedBody([
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'picture' => $user->getPictureUrl()
            ])->withAttribute(Fb\ProviderInterface::class, $token));

        } catch (\Exception $e) {
            return new JsonResponse([
                'code' => 404,
                'message' => 'Failed to get a user details'
            ], 401);
        }
    }
}
