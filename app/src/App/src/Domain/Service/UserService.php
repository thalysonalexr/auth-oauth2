<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Value\Uuid as u;
use App\Domain\Value\Email as e;
use App\Domain\Value\Password as p;
use App\Domain\Documents\User;
use App\Infrastructure\Repository\UserRepositoryInterface;

final class UserService implements UserServiceInterface
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $name, string $email, string $password): int
    {
        return $this->repository->create(
            User::newUser(u::newUuid(), $name, e::newEmail($email), p::newPassword($password))
        );
    }
}
