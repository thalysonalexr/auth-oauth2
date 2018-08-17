<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository\Exception;

use App\Exception\ExceptionInterface;

final class UserRepositoryException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function fromAmountValues(array $values): self
    {
        return new self(sprintf("Amount of wrong values ​​passed by the function parameter: ", (string) explode(', ', $values)));
    }

    public static function valueObjectInterface($value): self
    {
        return new self(sprintf("The value '%s' not implements interface %s", (string) $field, (string) \App\Domain\Value\valueObjectInterface::class));
    }
}
