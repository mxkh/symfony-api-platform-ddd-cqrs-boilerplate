<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\ChangeEmail;

use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class ChangeEmailCommand implements CommandInterface
{
    private UuidInterface $userUuid;

    private Email $email;

    public function __construct(string $userUuid, string $email)
    {
        $this->userUuid = Uuid::fromString($userUuid);
        $this->email = Email::fromString($email);
    }

    public function userUuid(): UuidInterface
    {
        return $this->userUuid;
    }

    public function email(): Email
    {
        return $this->email;
    }
}
