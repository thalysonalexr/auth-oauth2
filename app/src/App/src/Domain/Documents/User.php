<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\Email;
use App\Domain\Value\Password;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="login_facebook",
 *     collection="users",
 *     repositoryClass="LoginFacebook\UserRepository",
 *     indexes={
 *         @ODM\Index(keys={"email"="desc"}, options={"unique"=true})
 *     },
 *     readOnly=true,
 *     requireIndexes=true
 * )
 */
final class User implements \JsonSerializable
{
    /** @ODM\Id(strategy="NONE") */
    private $uuid;

    /** @ODM\Field(type="string") */
    private $name;

    /** @ODM\Field(type="string") */
    private $email;

    /** @ODM\Field(type="string") */
    private $password;

    private function __construct(
        Uuid $uuid,
        string $name,
        Email $email,
        Password $password
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
    }

    public function getId(): Uuid
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

    public static function newUser(
        Uuid $uuid,
        string $name,
        Email $email,
        Password $password
    ): self
    {
        return new self($uuid, $name, $email, $password);
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}
