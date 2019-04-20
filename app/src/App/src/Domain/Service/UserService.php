<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Value\Uuid as u;
use App\Domain\Value\StringValue as n;
use App\Domain\Value\Email as e;
use App\Domain\Value\Password as p;
use App\Domain\Documents\User;
use App\Domain\Service\Exception\UserNotFoundException;
use App\Domain\Service\Exception\UserEmailExistsException;
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

    public function create(string $name, string $email, string $password): bool
    {
        try {
            // verify if exists email in collections users
            // database not set a unique constraint for email
            $user = $this->getByEmail($email);

            if ($user instanceof User) {
                throw UserEmailExistsException::fromUserEmail($email);
            }
        } catch(UserNotFoundException $e) {
            $this->repository->create(
                User::newUser(
                    u::newUuid(),
                    n::newString(['name' => $name]),
                    e::newEmail($email),
                    p::newPassword($password)
                )
            );
        }

        return true;
    }

    public function getByEmail(string $email): ?User
    {
        $user = $this->repository->findOne([
            'email' => e::newEmail($email)
        ]);

        if ( ! $user instanceof User) {
            throw UserNotFoundException::fromUserEmail($email);
        }

        return $user;
    }
}
