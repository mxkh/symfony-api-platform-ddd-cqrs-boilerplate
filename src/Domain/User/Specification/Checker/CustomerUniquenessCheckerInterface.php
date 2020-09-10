<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\Specification\Checker;

use Sweetspot\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

interface CustomerUniquenessCheckerInterface
{
    public function isUnique(UuidInterface $uuid, Credentials $credentials): bool;
}
