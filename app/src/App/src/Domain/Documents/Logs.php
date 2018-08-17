<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\Date;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="login_facebook",
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
        Date $signinDt,
        ?Date $signoutDt,
        string $browser,
        string $ip,
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
        return $this->uuid;
    }

    public function getSigninDt(): Date
    {
        return $this->signinDt;
    }

    public function setSigninDt(Date $signinDt): void
    {
        $this->signinDt = $signinDt;
    }

    public function getSignoutDt(): ?Date
    {
        return $this->signoutDt;
    }

    public function setSignoutDt(?Date $signoutDt): void
    {
        $this->signoutDt = $signoutDt;
    }

    public function getBrowser(): string
    {
        return $this->browser;
    }

    public function setBrowser(string $browser): void
    {
        $this->browser = $browser;
    }

    public function getIp(): string
    {
        return $this->ip;
    }

    public function setIp(string $ip): void
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

    public static function newLogin(
        string $browser,
        string $ip,
        bool $status
    ): self
    {
        return new self(Uuid::newUuid(), Date::new(), null, $browser, $ip, $status);
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
