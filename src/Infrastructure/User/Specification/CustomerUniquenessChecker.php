<?php

declare(strict_types=1);

namespace Sweetspot\Infrastructure\User\Specification;

use Sweetspot\Domain\Shared\Specification\Checker\AggregateRootUniquenessCheckerInterface;
use Sweetspot\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Sweetspot\Domain\User\Specification\Checker\CustomerUniquenessCheckerInterface;
use Sweetspot\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

class CustomerUniquenessChecker implements CustomerUniquenessCheckerInterface
{
    private AggregateRootUniquenessCheckerInterface $aggregateRootUniquenessChecker;

    private CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker;

    public function __construct(
        AggregateRootUniquenessCheckerInterface $aggregateRootUniquenessChecker,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ) {
        $this->aggregateRootUniquenessChecker = $aggregateRootUniquenessChecker;
        $this->customerEmailUniquenessChecker = $customerEmailUniquenessChecker;
    }

    public function isUnique(UuidInterface $uuid, Credentials $credentials): bool
    {
        return $this->aggregateRootUniquenessChecker->isUnique($uuid)
            && $this->customerEmailUniquenessChecker->isUnique($credentials->email);
    }
}
