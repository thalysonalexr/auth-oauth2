<?php

declare(strict_types=1);

namespace App\Domain\Value;

final class Date implements \JsonSerializable, ValueObjectsInterface
{
    /**
     * @var string
     */
    private $date;

    private function __construct($date)
    {
        $this->date = $date;
    }

    public function getDate(): string
    {
        return $this->date;
    }

    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    public static function newDate(): self
    {
        return new self(
            (new \DateTime())->format('Y-m-d H:i:s')
        );
    }

    public static function fromString(string $date): self
    {
        return new self($date);
    }

    public static function fromDateTime(\DateTime $date): self
    {
        return new self($date);
    }

    public function convertToMongoDate(): \MongoDate
    {
        return new \MongoDate(strtotime($this->date));
    }

    public function __toString(): string
    {
        return $this->date;
    }

    public function jsonSerialize(): array
    {
        return [
            '__self' => self::class,
            'date' => $this->date
        ];
    }
}
