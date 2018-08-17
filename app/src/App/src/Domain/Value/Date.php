<?php

declare(strict_types=1);

namespace App\Domain\Value;

final class Date implements \JsonSerializable, ValueObjectsInterface
{
    /**
     * @var string
     */
    private $date;

    private function __construct(string $date)
    {
        $this->date = $date;
    }

    public static function new(): self
    {
        return new self(
            (new \DateTime())->format('Y-m-d H:i:s')
        );
    }

    public function __toString(): string
    {
        return $this->date;
    }
}
