<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\User;
use App\Domain\Documents\Logs;

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

    /**
     * Create a register of log
     * 
     * @param Logs $user
     * @return void
     */
    public function createLog(User $user, Logs $log): void;
}
