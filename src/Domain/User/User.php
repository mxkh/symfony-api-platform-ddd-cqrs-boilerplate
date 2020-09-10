<?php

declare(strict_types=1);

namespace Acme\Domain\User;

use Acme\Domain\AggregateRootBehaviourTrait;
use Acme\Domain\AggregateRootInterface;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\Event\UserWasCreated;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Domain\User\Specification\Rule\CustomerEmailMustBeUniqueRule;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Ramsey\Uuid\UuidInterface;

final class User implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private Credentials $credentials;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    public static function create(
        UuidInterface $uuid,
        Credentials $credentials,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ): self {
        static::checkRule(new CustomerEmailMustBeUniqueRule($customerEmailUniquenessChecker, $credentials->email));

        $user = new static();
        $user->addDomainEvent(new UserWasCreated($uuid, $credentials, DateTime::now()));

        return $user;
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid->toString();

        $this->setCredentials($event->credentials);
        $this->setCreatedAt($event->createdAt);
    }

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
