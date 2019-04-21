<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Documents\Logs;
use App\Domain\Documents\User;
use App\Infrastructure\Repository\LogsRepositoryInterface;

interface LogsServiceInterface
{
    public function __construct(LogsRepositoryInterface $repository);

    public function create(User $user, string $browser, string $ip, bool $status): ?Logs;
}
