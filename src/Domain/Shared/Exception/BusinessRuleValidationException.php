<?php

declare(strict_types=1);

namespace Acme\Domain\Shared\Exception;

use Acme\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;

final class BusinessRuleValidationException extends \Exception
{
    public function __construct(BusinessRuleSpecificationInterface $businessRuleSpecification)
    {
        $message = $businessRuleSpecification->validationMessage()->message;
        $code = $businessRuleSpecification->validationMessage()->code;

        parent::__construct($message, $code);
    }
}
