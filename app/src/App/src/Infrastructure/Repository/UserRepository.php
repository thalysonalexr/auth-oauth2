<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\User;
use App\Infrastructure\Repository\Exception\UserRepositoryException;
use Doctrine\Common\Persistence\ObjectManager;
use App\Domain\Value\ValueObjectsInterface;

final class UserRepository implements UserRepositoryInterface
{
    /**
     * @var ObjectManager
     */
    private $manager;

    /**
     * { @inheritdoc }
     */
    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * { @inheritdoc }
     */
    public function create(User $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush(null, ['safe' => true]);
    }

    /**
     * { @inheritdoc }
     * @throws UserRepositoryException
     */
    public function findOne(array $field = null): ?User
    {
        if (1 !== count($field)) {
            throw UserRepositoryException::fromAmountValues($field);
        }

        $key = key($field);

        if ( ! $field[$key] instanceof ValueObjectsInterface) {
            throw UserRepositoryException::valueObjectInterface($field[$key]);
        }

        return $this->manager->createQueryBuilder(User::class)
            ->field($key)->equals($field[$key]->__toString())
            ->getQuery()
            ->getSingleResult();
    }
}
