<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Value\Uuid as u;
use App\Domain\Value\StringValue as s;
use App\Domain\Value\Email as e;
use App\Domain\Value\Password as p;
use App\Domain\Documents\User;
use App\Domain\Documents\Logs;
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

    public function create(string $name, string $email, string $password): ?User
    {
        try {
            // verify if exists email in collections users
            // database not set a unique constraint for email
            $user = $this->getByEmail($email);

            if ($user instanceof User) {
                throw UserEmailExistsException::fromUserEmail($email);
            }
        } catch(UserNotFoundException $e) {
            $user = User::newUser(
                u::newUuid(),
                s::newString(['name' => $name]),
                e::newEmail($email),
                p::newPassword($password)
            );

            $this->repository->create($user);
        }

        return $user;
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

    public function createLog(User $user, string $browser, string $ip, bool $status): ?Logs
    {
        $log = Logs::newLog(
            u::newUuid(),
            s::newString(['browser' => $browser]),
            s::newString(['ip' => $ip]),
            $status
        );

        $this->repository->createLog($user, $log);

        return $log;
    }
}
