<?php

declare(strict_types=1);

namespace Acme\Domain\User\Event;

use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class UserWasCreated implements SerializerInterface
{
    public UuidInterface $uuid;

    public Credentials $credentials;

    public DateTime $createdAt;

    public function __construct(UuidInterface $uuid, Credentials $credentials, DateTime $createdAt)
    {
        $this->uuid = $uuid;
        $this->credentials = $credentials;
        $this->createdAt = $createdAt;
    }

    public function serialize($data, string $format, array $context = [])
    {
        // TODO: Implement serialize() method.
    }

    public function deserialize($data, string $type, string $format, array $context = [])
    {
        // TODO: Implement deserialize() method.
    }
}
