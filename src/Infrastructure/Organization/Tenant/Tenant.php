<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Organization\Tenant;

class Tenant implements TenantInterface
{
    private string $code;

    public function __construct(string $code)
    {
        $this->code = $code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function __toString(): string
    {
        return $this->getCode();
    }
}
