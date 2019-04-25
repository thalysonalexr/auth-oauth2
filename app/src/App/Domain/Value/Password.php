<?php

declare(strict_types=1);

namespace App\Domain\Value;

use App\Domain\Value\Exception\WrongPasswordException;

use function password_hash;

final class Password implements ValueObjectsInterface
{
    /**
     * @var array
     */
    const OPTIONS = [
        'cost' => 12
    ];
    /**
     * @var string
     */
    private $password;

    private function __construct(string $password)
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function __toString(): string
    {
        return $this->password;
    }

    public function jsonSerialize(): array
    {
        return [
            '__self' => self::class,
            'password' => $this->password
        ];
    }

    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, self::OPTIONS);
    }

    public static function verify(string $password, Password $hash): bool
    {
        if ( ! password_verify($password, $hash->getPassword())) {
            throw WrongPasswordException::fromWrongPassword($password);
        }

        return true;
    }

    public static function fromString(string $password): self
    {
        return new self($password);
    }

    public static function newPassword(string $password): self
    {
        return new self(self::encrypt($password));
    }
}
