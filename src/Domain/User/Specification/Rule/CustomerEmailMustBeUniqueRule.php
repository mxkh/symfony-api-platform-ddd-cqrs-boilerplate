<?php

declare(strict_types=1);

namespace Acme\Domain\User\Specification\Rule;

use Acme\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use Acme\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Domain\User\ValueObject\Email;

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
