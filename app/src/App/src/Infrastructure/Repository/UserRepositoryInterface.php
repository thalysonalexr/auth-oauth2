<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\User;
use Doctrine\ODM\MongoDB\DocumentManager;

interface UserRepositoryInterface
{
    public function __construct(DocumentManager $connection);

    public function create(User $user): int;
}
