<?php

declare(strict_types=1);

namespace Acme\Domain\Shared\Specification\Checker;

use Ramsey\Uuid\UuidInterface;

interface AggregateRootUniquenessCheckerInterface
{
    public function isUnique(UuidInterface $uuid): bool;
}
