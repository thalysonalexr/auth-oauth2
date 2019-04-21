<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\Date;
use App\Domain\Value\StringValue;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="login_oauth2",
 *     collection="logs"
 * )
 */
final class Logs implements \JsonSerializable
{
    /** @ODM\Id(strategy="NONE", type="string") */
    private $uuid;

    /** @ODM\Field(type="date") */
    private $signinDt;

    /** @ODM\Field(type="date") */
    private $signoutDt;

    /** @ODM\Field(type="string") */
    private $browser;
    
    /** @ODM\Field(type="string") */
    private $ip;

    /** @ODM\Field(type="bool") */
    private $status;

    private function __construct(
        Uuid $uuid,
        \MongoDate $signinDt,
        ?\MongoDate $signoutDt,
        StringValue $browser,
        StringValue $ip,
        bool $status
    )
    {
        $this->uuid = $uuid;
        $this->signinDt = $signinDt;
        $this->signoutDt = $signoutDt;
        $this->browser = $browser;
        $this->ip = $ip;
        $this->status = $status;
    }

    public function getId(): Uuid
    {
        if ($this->uuid instanceof Uuid) {
            return $this->uuid;
        }

        return Uuid::fromString($this->uuid);
    }

    public function getSigninDt(): Date
    {
        if ($this->signinDt instanceof Date) {
            return $this->signinDt;
        }

        if ($this->signinDt instanceof \DateTime) {
            return Date::fromDateTime($this->signinDt);
        }

        return Date::fromString($this->signinDt);
    }

    public function setSigninDt(Date $signinDt): void
    {
        $this->signinDt = $signinDt;
    }

    public function getSignoutDt(): ?Date
    {
        if ($this->signoutDt instanceof Date) {
            return $this->signoutDt;
        }

        if ($this->signoutDt instanceof \DateTime) {
            return Date::fromDateTime($this->signoutDt);
        }

        return Date::fromString($this->signoutDt);
    }

    public function setSignoutDt(?Date $signoutDt): void
    {
        $this->signoutDt = $signoutDt;
    }

    public function getBrowser(): StringValue
    {
        if ($this->browser instanceof StringValue) {
            return $this->browser;
        }

        return StringValue::fromString('browser', $this->browser);
    }

    public function setBrowser(StringValue $browser): void
    {
        $this->browser = $browser;
    }

    public function getIp(): StringValue
    {
        if ($this->ip instanceof StringValue) {
            return $this->ip;
        }

        return StringValue::fromString('ip', $this->ip);
    }

    public function setIp(StringValue $ip): void
    {
        $this->ip = $ip;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public static function newLog(
        Uuid $uuid,
        StringValue $browser,
        StringValue $ip,
        bool $status
    ): self
    {
        return new self($uuid, Date::newDate()->convertToMongoDate(), null, $browser, $ip, $status);
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'signin_date' => $this->signinDt,
            'signout_date' => $this->signoutDt,
            'browser' => $this->browser,
            'ip' => $this->ip,
            'status' => $this->status
        ];
    }
}
