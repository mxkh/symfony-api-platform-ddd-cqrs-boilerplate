<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant;

interface TenantInterface
{
    public function setCode(string $code): void;

    public function getCode(): string;

    public function __toString(): string;
}
