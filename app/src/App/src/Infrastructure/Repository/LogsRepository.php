<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\Logs;
use App\Domain\Documents\User;
use Doctrine\Common\Persistence\ObjectManager;

final class LogsRepository implements LogsRepositoryInterface
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
    public function create(User $user, Logs $log): void
    {
        $user->addLog($log);
        $this->manager->persist($user);
        $this->manager->flush(null, ['safe' => true]);
    }
}
