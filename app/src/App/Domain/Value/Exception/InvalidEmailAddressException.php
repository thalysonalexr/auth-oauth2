<?php

declare(strict_types=1);

namespace App\Domain\Value\Exception;

use App\Exception\ExceptionInterface;

final class InvalidEmailAddressException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function fromInvalidEmail(string $email): self
    {
        return new self(sprintf('This address ("%s") is missing and a valid format. Example: example@email.com', (string) $email));
    }
}
