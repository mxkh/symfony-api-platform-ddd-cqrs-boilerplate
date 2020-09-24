<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant\Context;

use Acme\Infrastructure\Organization\Tenant\TenantInterface;

interface TenantContextInterface
{
    public function getTenant(): ?TenantInterface;

    public function setTenant(TenantInterface $tenant): void;
}
