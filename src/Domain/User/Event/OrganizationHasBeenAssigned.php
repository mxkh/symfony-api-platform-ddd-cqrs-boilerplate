<?php

declare(strict_types=1);

namespace Acme\Domain\User\Event;

use Acme\Domain\Organization\Organization;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\ValueObject\Role;

final class OrganizationHasBeenAssigned
{
    public Organization $organization;

    public Role $role;

    public DateTime $updatedAt;

    public function __construct(Organization $organization, Role $role, DateTime $updatedAt)
    {
        $this->organization = $organization;
        $this->role = $role;
        $this->updatedAt = $updatedAt;
    }
}
