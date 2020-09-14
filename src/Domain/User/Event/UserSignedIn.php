<?php

declare(strict_types=1);

namespace Acme\Domain\User\Event;

use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

final class UserSignedIn
{
    public Email $email;

    public UuidInterface $uuid;

    public function __construct(UuidInterface $uuid, Email $email)
    {
        $this->uuid = $uuid;
        $this->email = $email;
    }
}
