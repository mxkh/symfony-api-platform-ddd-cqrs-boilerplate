<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant\Resolver;

use Acme\Infrastructure\Organization\Repository\OrganizationStore;
use Acme\Infrastructure\Organization\Tenant\TenantInterface;
use Acme\Infrastructure\Organization\Tenant\TenantOrganization;
use Ramsey\Uuid\Uuid;
use Symfony\Component\HttpFoundation\Request;

final class TenantOrganizationResolver implements TenantResolverInterface
{
    private OrganizationStore $organizationStore;

    public function __construct(OrganizationStore $organizationStore)
    {
        $this->organizationStore = $organizationStore;
    }

    public function resolve(?Request $request): TenantInterface
    {
        $tenantUuid = $request->headers->get('X-Organization');

        $organization = $this->organizationStore->get(Uuid::fromString($tenantUuid));

        return TenantOrganization::createFromOrganization($organization);
    }
}
