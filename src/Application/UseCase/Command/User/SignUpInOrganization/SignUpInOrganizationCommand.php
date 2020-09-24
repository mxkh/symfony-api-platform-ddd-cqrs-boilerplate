<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\User\SignUpInOrganization;

use Acme\Domain\Organization\Organization;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Acme\Domain\User\ValueObject\Auth\HashedPassword;
use Acme\Domain\User\ValueObject\Email;
use Acme\Infrastructure\Shared\Bus\Command\CommandInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class SignUpInOrganizationCommand implements CommandInterface
{
    private UuidInterface $uuid;

    private Credentials $credentials;

    private Organization $organization;

    public function __construct(string $uuid, string $email, string $plainPassword, Organization $organization)
    {
        $this->uuid = Uuid::fromString($uuid);
        $this->credentials = new Credentials(Email::fromString($email), HashedPassword::encode($plainPassword));
        $this->organization = $organization;
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function credentials(): Credentials
    {
        return $this->credentials;
    }

    public function organization(): Organization
    {
        return $this->organization;
    }
}
