<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\StringValue;
use App\Domain\Value\Email;
use App\Domain\Value\Password;
use App\Domain\Value\Date;
use App\Domain\Documents\Logs;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="login_facebook",
 *     collection="users",
 *     readOnly=true
 * )
 */
class User implements \JsonSerializable
{
    /** @ODM\Id(strategy="NONE", type="string") */
    private $uuid;

    /** @ODM\Field(type="string") */
    private $name;

    /** @ODM\Field(type="string") @ODM\Index */
    private $email;

    /** @ODM\Field(type="string") */
    private $password;

    /** @ODM\Field(type="date") */
    private $createdAt;

    /** @ODM\Field(type="string") */
    private $picture;

    /** @ODM\ReferenceMany(targetDocument="Logs", cascade="all") */
    private $logs = array();

    private function __construct(
        Uuid $uuid,
        StringValue $name,
        Email $email,
        Password $password,
        \MongoDate $createdAt
    )
    {
        $this->uuid = $uuid;
        $this->name = $name;
        $this->email = $email;
        $this->password = $password;
        $this->createdAt = $createdAt;
    }

    public function getId(): Uuid
    {
        if ($this->uuid instanceof Uuid) {
            return $this->uuid;
        }

        return Uuid::fromString($this->uuid);
    }

    public function getName(): StringValue
    {
        if ($this->name instanceof StringValue) {
            return $this->name;
        }

        return StringValue::fromString('name', $this->name);
    }

    public function setName(StringValue $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): Email
    {
        if ($this->email instanceof Email) {
            return $this->email;
        }

        return Email::fromString($this->email);
    }

    public function setEmail(Email $email): void
    {
        $this->email = $email;
    }

    public function getPassword(): Password
    {
        if ($this->password instanceof Password) {
            return $this->password;
        }

        return Password::fromString($this->password);
    }

    public function setPassword(Password $password): void
    {
        $this->password = $password;
    }

    public function getCreatedAt(): Date
    {
        if ($this->createdAt instanceof Date) {
            return $this->createdAt;
        }

        if ($this->createdAt instanceof \DateTime) {
            return Date::fromDateTime($this->createdAt);
        }

        return Date::fromString($this->createdAt);
    }

    public function getPicture(): StringValue
    {
        if ($this->picture instanceof StringValue) {
            return $this->picture;
        }

        return StringValue::fromString('picture', $this->picture);
    }

    public function setPicture(StringValue $picture): void
    {
        $this->picture = $picture;
    }

    public function getLogs(): array
    {
        return $this->logs;
    }

    public function setLogs(array $logs): void
    {
        $this->logs = $logs;
    }

    public function addLog(Logs $log): void
    {
        $this->logs[] = $log;
    }

    public static function newUser(
        Uuid $uuid,
        StringValue $name,
        Email $email,
        Password $password
    ): self
    {
        return new self($uuid, $name, $email, $password, Date::newDate()->convertToMongoDate());
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'created_at' => $this->createdAt,
            'picture' => $this->getPicture,
            'logs' => $this->logs
        ];
    }
}
