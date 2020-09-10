<?php

declare(strict_types=1);

namespace Acme\Domain\User\Specification\Checker;

use Acme\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

interface CustomerUniquenessCheckerInterface
{
    public function isUnique(UuidInterface $uuid, Credentials $credentials): bool;
}
