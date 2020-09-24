<?php

declare(strict_types=1);

namespace Acme\Domain\User;

use Acme\Domain\Organization\Organization;
use Acme\Domain\User\ValueObject\Role;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UserRole
{
    private UuidInterface $uuid;

    private Role $role;

    private Organization $organization;

    private User $user;

    public function __construct()
    {
        $this->uuid = Uuid::uuid4();
    }

    public function setRole(Role $role): void
    {
        $this->role = $role;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    public function setOrganization(Organization $organization): void
    {
        $this->organization = $organization;
    }
}
