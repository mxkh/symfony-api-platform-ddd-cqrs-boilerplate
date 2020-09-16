<?php

declare(strict_types=1);

namespace Acme\Domain\User\Event;

use Acme\Domain\Shared\Event\DomainEventInterface;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

final class UserEmailChanged implements DomainEventInterface
{
    public UuidInterface $uuid;

    public Email $email;

    public DateTime $updatedAt;

    public function __construct(UuidInterface $uuid, Email $email, DateTime $updatedAt)
    {
        $this->email = $email;
        $this->uuid = $uuid;
        $this->updatedAt = $updatedAt;
    }
}
