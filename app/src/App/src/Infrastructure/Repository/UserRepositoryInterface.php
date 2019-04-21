<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\User;

interface UserRepositoryInterface extends RepositoryInterface
{    
    /**
     * Create a new user
     * 
     * @param User $user
     * @return void
     */
    public function create(User $user): void;

    /**
     * Find one user by statements
     * 
     * @param array $field
     * @return User
     */
    public function findOne(array $field = null): ?User;
}
