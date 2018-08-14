<?php

declare(strict_types=1);

namespace App\Domain\Value;

use Ramsey\Uuid\Uuid as GeneratorUuid;
use Ramsey\Uuid\UuidInterface;

final class Uuid implements ValueObjectsInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public static function newUuid(): self
    {
        return new self(GeneratorUuid::uuid4());
    }

    public static function fromString(string $uuid): self
    {
        return new self(GeneratorUuid::fromString($uuid));
    }

    public function __toString(): string
    {
        return $this->uuid->toString();
    }
}
