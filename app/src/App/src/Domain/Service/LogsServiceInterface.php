<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Infrastructure\Repository\LogsRepositoryInterface;

interface LogsServiceInterface
{
    public function __construct(LogsRepositoryInterface $repository);

    public function create(string $browser, string $ip, bool $status): ?Logs;
}
