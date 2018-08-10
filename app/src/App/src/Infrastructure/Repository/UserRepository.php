<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\User;
use Doctrine\ODM\MongoDB\DocumentManager;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var DocumentManager
     */
    private $connection;

    public function __construct(DocumentManager $connection)
    {
        $this->connection = $connection;
    }

    public function create(User $user): int
    {
        $this->connection->persist($user);
        $this->connection->flush();
    }
}
