<?php

declare(strict_types=1);

namespace App\Domain\Documents;

use App\Domain\Value\Uuid;
use App\Domain\Value\Date;
use App\Domain\Value\StringValue;
use App\Domain\Value\Email;
use App\Domain\Value\Password;
use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * @ODM\Document(
 *     db="auth_oauth2",
 *     collection="users_oauth",
 *     readOnly=true
 * )
 */
final class UserOauth extends User
{
    /** @ODM\Field(type="string") */
    private $userId;

    /** @ODM\Field(type="string") */
    private $provider;

    private function __construct(
        Uuid $uuid,
        StringValue $name,
        Email $email,
        ?StringValue $picture,
        \MongoDate $createdAt,
        StringValue $userId,
        StringValue $provider
    )
    {
        $this->userId = $userId;
        $this->provider = $provider;
        parent::__construct($uuid, $name, $email, null, $createdAt, $picture);
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

    public static function newUserOauth(
        Uuid $uuid,
        StringValue $name,
        Email $email,
        ?StringValue $picture,
        StringValue $userId,
        StringValue $provider
    ): self
    {
        return new self($uuid, $name, $email, $picture, Date::newDate()->convertToMongoDate(), $userId, $provider);
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
