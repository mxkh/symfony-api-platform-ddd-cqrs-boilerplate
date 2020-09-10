<?php

namespace Sweetspot\Domain\Shared\Specification\Rule;

use Sweetspot\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;

interface BusinessRuleSpecificationInterface
{
    public function isSatisfiedBy(): bool;

    public function validationMessage(): BusinessRuleValidationMessage;
}
