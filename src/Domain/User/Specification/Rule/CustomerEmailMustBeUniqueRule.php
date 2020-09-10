<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\Specification\Rule;

use Sweetspot\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use Sweetspot\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use Sweetspot\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Sweetspot\Domain\User\ValueObject\Email;

final class CustomerEmailMustBeUniqueRule implements BusinessRuleSpecificationInterface
{
    private CustomerEmailUniquenessCheckerInterface $uniqueEmailSpecification;

    private Email $email;

    public function __construct(CustomerEmailUniquenessCheckerInterface $uniqueEmailSpecification, Email $email)
    {
        $this->uniqueEmailSpecification = $uniqueEmailSpecification;
        $this->email = $email;
    }

    public function isSatisfiedBy(): bool
    {
        return $this->uniqueEmailSpecification->isUnique($this->email);
    }

    public function validationMessage(): BusinessRuleValidationMessage
    {
        return new BusinessRuleValidationMessage('Customer with this email already exists', 004);
    }
}
