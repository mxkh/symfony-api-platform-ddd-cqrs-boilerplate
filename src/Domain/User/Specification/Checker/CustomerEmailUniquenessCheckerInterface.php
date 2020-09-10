<?php

namespace Sweetspot\Domain\User\Specification\Checker;

use Sweetspot\Domain\User\ValueObject\Email;

interface CustomerEmailUniquenessCheckerInterface
{
    public function isUnique(Email $email): bool;
}
