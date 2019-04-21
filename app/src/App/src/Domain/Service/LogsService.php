<?php

declare(strict_types=1);

namespace App\Domain\Service;

use App\Domain\Value\Uuid as u;
use App\Domain\Value\Date as d;
use App\Domain\Value\StringValue as s;
use App\Domain\Documents\Logs;

final class LogsService implements LogsServiceInterface
{
    /**
     * @var LogsRepositoryInterface
     */
    private $repository;

    public function __construct(LogsRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(string $browser, string $ip, bool $status): ?Logs
    {
        $log = Logs::newLog(
            u::newUuid(),
            d::newDate(),
            s::newString(['browser' => $browser]),
            s::newString(['ip' => $ip]),
            $status
        );

        $this->repository->create($log);

        return $log;
    }
}
