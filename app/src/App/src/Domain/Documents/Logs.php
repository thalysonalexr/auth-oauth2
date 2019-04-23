<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Jti;
use App\Domain\Value\Uuid;
use App\Domain\Value\Date;
use App\Domain\Value\StringValue;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="auth_oauth2",
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

    /** @ODM\Field(type="string") */
    private $jti;

    /** @ODM\Field(type="bool") */
    private $status;

    /** @ODM\Field(type="bool") */
    private $timeout;

    private function __construct(
        Uuid $uuid,
        \MongoDate $signinDt,
        ?\MongoDate $signoutDt,
        StringValue $browser,
        StringValue $ip,
        Jti $jti,
        bool $status,
        ?bool $timeout
    )
    {
        $this->uuid = $uuid;
        $this->signinDt = $signinDt;
        $this->signoutDt = $signoutDt;
        $this->browser = $browser;
        $this->ip = $ip;
        $this->jti = $jti;
        $this->status = $status;
        $this->timeout = $timeout;
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

    public function getJti(): Jti
    {
        if ($this->jti instanceof Jti) {
            return $this->jti;
        }

        return Jti::fromString($this->jti);
    }

    public function setJti(Jti $jti): void
    {
        $this->jti = $jti;
    }

    public function getStatus(): bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): void
    {
        $this->status = $status;
    }

    public function getTimeout(): bool
    {
        return $this->timeout;
    }

    public function setTimeout(bool $timeout): void
    {
        $this->timeout = $timeout;
    }

    public static function newLog(
        Uuid $uuid,
        StringValue $browser,
        StringValue $ip,
        Jti $jti,
        bool $status
    ): self
    {
        return new self($uuid, Date::newDate()->convertToMongoDate(), null, $browser, $ip, $jti, $status, null);
    }

    public function jsonSerialize(): array
    {
        return [
            'uuid' => $this->uuid,
            'signin_date' => $this->signinDt,
            'signout_date' => $this->signoutDt,
            'browser' => $this->browser,
            'ip' => $this->ip,
            'jti' => $this->jti,
            'status' => $this->status,
            'timeout' => $this->timeout
        ];
    }
}
