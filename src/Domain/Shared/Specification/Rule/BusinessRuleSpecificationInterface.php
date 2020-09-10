<?php

namespace Acme\Domain\Shared\Specification\Rule;

use Acme\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;

interface BusinessRuleSpecificationInterface
{
    public function isSatisfiedBy(): bool;

    public function validationMessage(): BusinessRuleValidationMessage;
}
