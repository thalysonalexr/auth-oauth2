<?php

declare(strict_types=1);

namespace App\Domain\Service\Exception;

use App\Exception\ExceptionInterface;

final class UserNotFoundException extends \RuntimeException implements ExceptionInterface
{
    public static function fromUserId(int $id): self
    {
        return new self(sprintf('No user was found for id "%s"', (string) $id));
    }

    public static function fromUserEmail(string $email): self
    {
        return new self(sprintf('No user was found for email "%s"', (string) $email));
    }

    public static function fromAmountValues(array $values): self
    {
        return new self(sprintf('No user was found for values { %s }', (string)
            implode(', ', array_map(function ($index) use ($values) {
                return "$index => " . $values[$index];
            }, array_keys($values)))
        ));
    }
}
