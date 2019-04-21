<?php

declare(strict_types=1);

namespace App\Domain\Service\Exception;

use App\Exception\ExceptionInterface;

final class UserOauthExistsException extends \DomainException implements ExceptionInterface
{
    public static function fromAmountValues(array $values): self
    {
        return new self(sprintf('Users with the following values ​​already exist { %s }', (string)
            implode(', ', array_map(function ($index) use ($values) {
                return "$index => " . $values[$index];
            }, array_keys($values)))
        ));
    }
}
