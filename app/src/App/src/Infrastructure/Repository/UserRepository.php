<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Value\Uuid;
use App\Domain\Documents\User;
use Doctrine\ODM\MongoDB\DocumentManager;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var DocumentManager
     */
    private $document;

    public function __construct(DocumentManager $document)
    {
        $this->document = $document;
    }

    public function create(User $user): void
    {
        $this->document->persist($user);
        $this->document->flush();
    }

    public function findOneById(Uuid $uuid): ?User
    {
        return $this->findOne(["_id" => $uuid]);
    }

    public function findOneByEmail(Email $email): ?User
    {
        return $this->findOne(["email" => $email]);
    }

    public function findOne(array $field = null): ?User
    {
        // throw exception case count array > 1
        return $this->document->createQueryBuilder(User::class)
            ->find(key($field))
            ->equals($field[0])
            ->getQuery()
            ->getSingleResult();
    }
}
