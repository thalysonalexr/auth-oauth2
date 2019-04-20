<?php

declare(strict_types=1);

namespace App\Domain\Value;

use App\Domain\Value\Exception\InvalidStringValueException;

use function is_string;
use function key;

final class StringValue implements \JsonSerializable, ValueObjectsInterface
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    private $value;

    private function __construct(array $arr)
    {
        if ( ! self::isValid($arr)) {
            throw InvalidStringValueException::invalidParams($arr);
        }

        $this->key = key($arr);
        $this->value = $arr[key($arr)];
    }

    public function getString(): string
    {
        return $this->value;
    }

    public function setString(string $value): void
    {
        $this->value = $value;
    }

    public static function isValid($value): bool
    {
        return count($value) === 1 && is_string(key($value)) && is_string($value[key($value)]);
    }

    public function isEmpty(): bool
    {
        return empty($this->value);
    }

    public static function newString(array $arr): self
    {
        return new self($arr);
    }

    public static function fromString(string $key, string $value): self
    {
        return new self([$key => $value]);
    }

    public function jsonSerialize(): array
    {
        return [
            '__self' => self::class,
            $this->key => $this->value
        ];
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
