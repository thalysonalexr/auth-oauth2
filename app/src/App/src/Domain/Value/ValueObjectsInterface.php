<?php

declare(strict_types=1);

namespace App\Domain\Value;

interface ValueObjectsInterface
{
    public function __toString(): string;
}
