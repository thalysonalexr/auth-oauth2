<?php

declare(strict_types=1);

namespace App\Domain\Documents;

final class UserOauth extends User implements \JsonSerializable
{
    private $uuid;

    private $userId;

    private $provider;

    public function __construct()
    {
    }

    public function jsonSerialize(): array
    {
        return [
        ];
    }
}
