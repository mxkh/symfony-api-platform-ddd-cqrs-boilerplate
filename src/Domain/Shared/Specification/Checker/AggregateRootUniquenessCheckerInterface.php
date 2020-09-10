<?php

declare(strict_types=1);

namespace Sweetspot\Domain\Shared\Specification\Checker;

use Ramsey\Uuid\UuidInterface;

interface AggregateRootUniquenessCheckerInterface
{
    public function isUnique(UuidInterface $uuid): bool;
}
