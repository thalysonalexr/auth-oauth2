<?php

declare(strict_types=1);

namespace App\Domain\Value\Exception;

use App\Exception\ExceptionInterface;

final class InvalidStringValueException extends \InvalidArgumentException implements ExceptionInterface
{
    public static function invalidParams($params): self
    {
        return new self(sprintf("Poorly formed parameters or params is not string type. Params: %s", (string) array_map($params, 
            function ($index, $value) {
                return "$index => $value";
            })));
    }
}
