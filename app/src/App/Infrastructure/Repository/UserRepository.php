<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\Logs;
use App\Domain\Documents\User;
use App\Domain\Documents\UserInterface;
use App\Domain\Value\ValueObjectsInterface;
use App\Domain\Value\Jti;
use App\Infrastructure\Repository\Exception\UserRepositoryException;
use Doctrine\Common\Persistence\ObjectManager;

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
    public function create(UserInterface $user): void
    {
        $this->manager->persist($user);
        $this->manager->flush(null, ['safe' => true]);
    }

    /**
     * { @inheritdoc }
     * @throws UserRepositoryException
     */
    public function findOne(array $field, string $className): ?UserInterface
    {
        if (1 !== count($field)) {
            throw UserRepositoryException::fromAmountValues($field);
        }

        $key = key($field);

        if ( ! $field[$key] instanceof ValueObjectsInterface) {
            throw UserRepositoryException::valueObjectInterface($field[$key]);
        }

        return $this->manager->createQueryBuilder($className)
            ->field($key)->equals($field[$key]->__toString())
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * { @inheritdoc }
     */
    public function whereEquals(array $fields, string $className): ?UserInterface
    {
        $statement = implode(' && ', array_map(function ($index) use ($fields) {
            return "this.$index == '" . $fields[$index] . "'";
        }, array_keys($fields)));

        return $this->manager->createQueryBuilder($className)
            ->where("function () { return $statement; }")
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * { @inheritdoc }
     */
    public function createLog(UserInterface $user, Logs $log): void
    {
        $user->addLog($log);
        $this->manager->persist($user);
        $this->manager->flush(null, ['safe' => true]);
    }

    public function updateLog(Jti $jti, array $fields): bool
    {
        $log = $this->manager->createQueryBuilder(Logs::class)
            ->findAndUpdate()
            ->field('jti')->equals($jti->getValue())
            ->sort('prority', 'desc');

        foreach ($fields as $key => $value) {
            $log->field($key)->set($value);
        }

        if ($log->getQuery()->execute() instanceof Logs) {
            return true;
        }

        return false;
    }
}
