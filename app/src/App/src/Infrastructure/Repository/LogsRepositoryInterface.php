<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Documents\Logs;

interface LogsRepositoryInterface
{
    /**
     * Create a register of log
     * 
     * @param Logs $user
     * @return void
     */
    public function create(Logs $log): void;
}
