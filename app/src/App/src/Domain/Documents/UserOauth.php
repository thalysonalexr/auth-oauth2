<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\StringValue;
use App\Domain\Value\Email;
use App\Domain\Value\Password;

final class UserOauth extends User implements \JsonSerializable
{
    /** @ODM\Field(type="string") */
    private $userId;

    /** @ODM\Field(type="string") */
    private $provider;

    private function __construct(
        Uuid $uuid,
        StringValue $name,
        Email $email,
        Password $password,
        \MongoDate $createdAt,
        StringValue $userId,
        StringValue $provider
    )
    {
        $this->userId = $userId;
        $this->provider = $provider;
        parent::__construct($uuid, $name, $email, $password, $createdAt);
    }

    public function getUserId(): StringValue
    {
        if ($this->userId instanceof StringValue) {
            return $this->userId;
        }

        return StringValue::fromString('user_id', $this->userId);
    }

    public function setUserId(StringValue $userId): void
    {
        $this->userId = $userId;
    }

    public function getProvider(): StringValue
    {
        if ($this->provider instanceof StringValue) {
            return $this->provider;
        }

        return StringValue::fromString('provider', $this->provider);
    }

    public function setProvider(StringValue $provider): void
    {
        $this->provider = $provider;
    }

    public function jsonSerialize(): array
    {
        return array_merge(parent::jsonSerialize(), [
            [
                'user_id' => $this->userId,
                'provider' => $this->provider
            ]
        ]);
    }
}
