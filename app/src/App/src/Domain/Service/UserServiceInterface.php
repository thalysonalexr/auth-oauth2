<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Documents\Logs;
use App\Domain\Documents\UserInterface;
use App\Infrastructure\Repository\UserRepositoryInterface;

interface UserServiceInterface
{
    public function __construct(UserRepositoryInterface $repository);

    public function create(string $name, string $email, string $password): ?UserInterface;

    public function getByEmail(string $email, string $className): ?UserInterface;

    public function createLog(UserInterface $user, string $browser, string $ip, string $jti, bool $status): ?Logs;

    public function createOauth(string $provider, string $userId, string $name, string $email, ?string $picture): ?UserInterface;

    public function signout(string $jti): bool;

    public function timeout(string $jti): bool;
}
