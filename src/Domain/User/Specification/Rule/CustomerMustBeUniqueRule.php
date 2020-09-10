<?php

declare(strict_types=1);

namespace Sweetspot\Domain\User\Specification\Rule;

use Sweetspot\Domain\Shared\Specification\Rule\BusinessRuleSpecificationInterface;
use Sweetspot\Domain\Shared\ValueObject\Specification\BusinessRuleValidationMessage;
use Sweetspot\Domain\User\Specification\Checker\CustomerUniquenessCheckerInterface;
use Sweetspot\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

final class CustomerMustBeUniqueRule implements BusinessRuleSpecificationInterface
{
    private CustomerUniquenessCheckerInterface $customerUniquenessChecker;

    private UuidInterface $uuid;

    private Credentials $credentials;

    public function __construct(
        CustomerUniquenessCheckerInterface $customerUniquenessChecker,
        UuidInterface $uuid,
        Credentials $credentials
    ) {

        $this->customerUniquenessChecker = $customerUniquenessChecker;
        $this->uuid = $uuid;
        $this->credentials = $credentials;
    }

    public function isSatisfiedBy(): bool
    {
        return $this->customerUniquenessChecker->isUnique($this->uuid, $this->credentials);
    }

    public function validationMessage(): BusinessRuleValidationMessage
    {
        return new BusinessRuleValidationMessage('Customer already exists', 044);
    }
}
