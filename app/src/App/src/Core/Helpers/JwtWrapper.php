<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Tuupola\Base62;
use Firebase\JWT\JWT;
use App\Domain\Documents\UserInterface;

use function random_bytes;

trait JwtWrapper
{
    private function createJwt(UserInterface $user, int $minutes = 20): \StdClass
    {
        $future = (new \DateTime("+$minutes minutes"))->getTimestamp();

        $payload = [
            'iat' => (new \DateTime())->getTimestamp(),
            'exp' => $future,
            'jti' => (new Base62)->encode(random_bytes(16)),
            'data' => [
                'id' => (string) $user->getId()->__toString(),
                'name' => $user->getName()->__toString(),
                'email' => $user->getEmail()->__toString()
            ]
        ];

        return (object) [
            'exp' => $future,
            'token' => JWT::encode($payload, $this->jwtSecret, 'HS256')
        ];
    }
}
