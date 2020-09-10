<?php

namespace Acme\Domain\User\Specification\Checker;

use Acme\Domain\User\ValueObject\Email;

interface CustomerEmailUniquenessCheckerInterface
{
    public function isUnique(Email $email): bool;
}
