<?php

declare(strict_types=1);

namespace App\Domain\Value;

use App\Domain\Value\Exception\InvalidEmailAddressException;

use function filter_var;

final class Email implements ValueObjectsInterface
{
    /**
     * @var string
     */
    private $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public static function validate(string $email): string
    {
        if ( ! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw InvalidEmailAddressException::fromInvalidEmail($email);
        }
        
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    public static function fromString(string $email): self
    {
        return new self($email);
    }

    public static function newEmail(string $email): self
    {
        return new self(self::validate($email));
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): array
    {
        return [
            '__self' => self::class,
            'email' => $this->email
        ];
    }
}
