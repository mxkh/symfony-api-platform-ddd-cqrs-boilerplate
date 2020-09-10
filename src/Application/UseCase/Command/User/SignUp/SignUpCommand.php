<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUp;

use Acme\Domain\User\ValueObject\Auth\Credentials;
use Acme\Domain\User\ValueObject\Auth\HashedPassword;
use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SignUpCommand
{
    private UuidInterface $uuid;

    private Credentials $credentials;

    public function __construct(string $uuid, string $email, string $plainPassword)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::encode($plainPassword));
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }
}
