<?php

declare(strict_types=1);

namespace App\Domain\Value;

use App\Domain\Value\Exception\WrongPasswordException;

use function password_hash;

final class Password implements \JsonSerializable, ValueObjectsInterface
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
            'password' => $password
        ];
    }

    public static function encrypt(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT, self::OPTIONS);
    }

    public static function verify(Password $password, string $hash): bool
    {
        if ( ! password_verify($password->getPassword(), $hash)) {
            throw WrongPasswordException::fromWrongPassword($password);
        }
        return true;
    }

    public static function newPassword(string $password): self
    {
        return new self(self::encrypt($password));
    }
}
