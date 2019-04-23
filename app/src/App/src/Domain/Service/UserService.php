<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Value\Uuid as u;
use App\Domain\Value\StringValue as s;
use App\Domain\Value\Email as e;
use App\Domain\Value\Password as p;
use App\Domain\Value\Jti as j;
use App\Domain\Documents\User;
use App\Domain\Documents\UserOauth;
use App\Domain\Documents\UserInterface;
use App\Domain\Documents\Logs;
use App\Domain\Service\Exception\UserNotFoundException;
use App\Domain\Service\Exception\UserEmailExistsException;
use App\Domain\Service\Exception\UserOauthExistsException;
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

    public function create(string $name, string $email, string $password): ?UserInterface
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

    public function getByEmail(string $email, string $className): ?UserInterface
    {
        $user = $this->repository->findOne([
            'email' => e::newEmail($email)
        ], $className);

        if ( ! $user instanceof UserInterface) {
            throw UserNotFoundException::fromUserEmail($email);
        }

        return $user;
    }

    public function getByOauth(string $provider, string $userId, string $email): ?UserInterface
    {
        $values = [
            'provider' => $provider,
            'userId' => $userId,
            'email' => $email
        ];

        $user = $this->repository->whereEquals($values, UserOauth::class);

        if ( ! $user instanceof UserOauth) {
            throw UserNotFoundException::fromAmountValues($values);
        }

        return $user;
    }

    public function createLog(UserInterface $user, string $browser, string $ip, string $jti, bool $status): ?Logs
    {
        $log = Logs::newLog(
            u::newUuid(),
            s::newString(['browser' => $browser]),
            s::newString(['ip' => $ip]),
            j::newJti($jti),
            $status
        );

        $this->repository->createLog($user, $log);

        return $log;
    }

    public function createOauth(string $provider, string $userId, string $name, string $email, ?string $picture): ?UserInterface
    {
        // verify if exists provider | user_id | email in usersoath collection to don't create register
        try {
            $user = $this->getByOauth($provider, $userId, $email);

            if ($user instanceof UserOauth) {
                throw UserOauthExistsException::fromAmountValues([
                    'provider' => $provider,
                    'user_id' => $userId,
                    'email' => $email
                ]);
            }
        } catch (UserNotFoundException $e) {
            $user = UserOauth::newUserOauth(
                u::newUuid(),
                s::newString(['name' => $name]),
                e::newEmail($email),
                s::newString(['user_id' => $userId]),
                s::newString(['provider' => $provider])
            );

            $this->repository->create($user);
        }

        return $user;
    }
}
