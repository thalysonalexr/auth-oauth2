<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

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
    public function create(Logs $log): void
    {
        $this->manager->persist($log);
        $this->manager->flush(null, ['safe' => true]);
    }
}
