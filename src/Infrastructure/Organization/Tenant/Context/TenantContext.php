<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant\Context;

use Acme\Infrastructure\Organization\Tenant\Resolver\TenantResolverInterface;
use Acme\Infrastructure\Organization\Tenant\TenantInterface;
use Symfony\Component\HttpFoundation\RequestStack;

final class TenantContext implements TenantContextInterface
{
    private ?TenantInterface $tenant = null;

    private TenantResolverInterface $tenantResolver;

    private RequestStack $requestStack;

    public function __construct(
        TenantResolverInterface $tenantResolver,
        RequestStack $requestStack
    ) {
        $this->tenantResolver = $tenantResolver;
        $this->requestStack = $requestStack;
    }

    public function getTenant(): ?TenantInterface
    {
        if (null !== $this->tenant) {
            return $this->tenant;
        }

        $currentRequest = $this->requestStack->getCurrentRequest();
        $tenant = $this->tenantResolver->resolve($currentRequest);

        if (null === $tenant) {
            return null;
        }

        $this->setTenant($tenant);

        return $tenant;
    }

    public function setTenant(TenantInterface $tenant): void
    {
        $this->tenant = $tenant;
    }
}
