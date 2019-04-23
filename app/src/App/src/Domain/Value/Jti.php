<?php

declare(strict_types=1);

namespace App\Domain\Value;

use App\Domain\Value\Exception\InvalidJtiException;

use function is_string;

final class Jti implements ValueObjectsInterface
{
    /**
     * @var int
     */
    const MIN_LENGTH = 16;

    /**
     * @var int
     */
    const MAX_LENGTH = 64;

    /**
     * @var string
     */
    private $jti;

    public function getValue(): string
    {
        return $this->jti;
    }

    private function __construct(string $jti)
    {
        if (is_string($jti) && strlen($jti) >= self::MIN_LENGTH && strlen($jti) <= self::MAX_LENGTH) {
            $this->jti = $jti;
        } else {
            throw InvalidJtiException::message($jti, self::MIN_LENGTH, self::MAX_LENGTH);
        }
    }

    public static function fromString(string $jti): self
    {
        return new self($jti);
    }

    public static function newJti(string $jti): self
    {
        return new self($jti);
    }

    public function jsonSerialize(): array
    {
        return [
            '__self' => self::class,
            'jti' => $this->jti
        ];
    }

    public function __toString(): string
    {
        return $this->jti;
    }
}
