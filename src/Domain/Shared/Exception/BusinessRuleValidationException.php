<?php

declare(strict_types=1);

namespace Sweetspot\Domain\Shared\Exception;

use Sweetspot\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;

final class BusinessRuleValidationException extends \Exception
{
    public function __construct(BusinessRuleSpecificationInterface $businessRuleSpecification)
    {
        $message = $businessRuleSpecification->validationMessage()->message;
        $code = $businessRuleSpecification->validationMessage()->code;

        parent::__construct($message, $code);
    }
}
