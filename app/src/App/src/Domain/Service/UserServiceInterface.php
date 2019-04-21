<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Documents\User;
use App\Infrastructure\Repository\UserRepositoryInterface;

interface UserServiceInterface
{
    public function __construct(UserRepositoryInterface $repository);

    public function create(string $name, string $email, string $password): ?User;

    public function getByEmail(string $email): ?User;
}
