<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use Doctrine\Common\Persistence\ObjectManager;

interface RepositoryInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function __construct(ObjectManager $manager);
}
