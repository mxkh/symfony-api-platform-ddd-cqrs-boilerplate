<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant;

use Acme\Domain\Organization\Organization;

final class TenantOrganization extends Tenant
{
    private Organization $organization;

    public static function createFromOrganization(Organization $organization): self
    {
        $tenant = new self($organization->getUuid()->toString());
        $tenant->setOrganization($organization);

        return $tenant;
    }

    public function getOrganization(): Organization
    {
        return $this->organization;
    }

    public function setOrganization(Organization $organization): void
    {
        $this->organization = $organization;
    }
}
