<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\Repository;

use Acme\Domain\Organization\Organization;
use Ramsey\Uuid\UuidInterface;

interface OrganizationRepositoryInterface
{
    public function get(UuidInterface $uuid): Organization;

    public function store(Organization $organization): void;
}
