<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Value\Jti;
use App\Domain\Documents\Logs;
use App\Domain\Documents\UserInterface;

interface UserRepositoryInterface extends RepositoryInterface
{    
    /**
     * Create a new user
     * 
     * @param UserInterface $user
     * @return void
     */
    public function create(UserInterface $user): void;

    /**
     * Find one user by statements
     * 
     * @param array $field
     * @return UserInterface
     */
    public function findOne(array $field, string $className): ?UserInterface;

    /**
     * Find one user by statements
     * 
     * @param array $fields
     * @param string $className
     * @return UserInterface
     */
    public function whereEquals(array $fields, string $className): ?UserInterface;

    /**
     * Create a register of log
     * 
     * @param UserInterface $user
     * @param Logs $user
     * @return void
     */
    public function createLog(UserInterface $user, Logs $log): void;

    /**
     * Update fields in log
     * 
     * @param Jti $jti
     * @param array $fields
     * @return bool
     */
    public function updateLog(Jti $jti, array $fields): bool;
}
