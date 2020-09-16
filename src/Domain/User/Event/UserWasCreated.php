<?php

declare(strict_types=1);

namespace Acme\Domain\User\Event;

use Acme\Domain\Shared\Event\DomainEventInterface;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

final class UserWasCreated implements DomainEventInterface
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
}
