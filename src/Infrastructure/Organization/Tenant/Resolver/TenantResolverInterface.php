<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant\Resolver;

use Acme\Infrastructure\Organization\Tenant\TenantInterface;
use Symfony\Component\HttpFoundation\Request;

interface TenantResolverInterface
{
    public function resolve(?Request $request): ?TenantInterface;
}
