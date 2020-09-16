<?php

declare(strict_types=1);

namespace Acme\Domain\User;

use Acme\Domain\AggregateRootBehaviourTrait;
use Acme\Domain\AggregateRootInterface;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\Event\UserEmailChanged;
use Acme\Domain\User\Event\UserSignedIn;
use Acme\Domain\User\Event\UserWasCreated;
use Acme\Domain\User\Exception\InvalidCredentialsException;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Domain\User\Specification\Rule\CustomerEmailMustBeUniqueRule;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class User implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private Credentials $credentials;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    private DateTime $loggedAt;

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

    public function signIn(string $plainPassword): void
    {
        if (!$this->credentials->password->match($plainPassword)) {
            throw new InvalidCredentialsException('Invalid credentials entered.');
        }

        $this->addDomainEvent(new UserSignedIn($this->uuid, $this->credentials->email));
    }

    public function changeEmail(
        Email $email,
        CustomerEmailUniquenessCheckerInterface $uniqueEmailSpecification
    ): void {
        $uniqueEmailSpecification->isUnique($email);
        $this->addDomainEvent(new UserEmailChanged($this->uuid, $email, DateTime::now()));
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid;

        $this->setCredentials($event->credentials);
        $this->setCreatedAt($event->createdAt);
    }

    protected function applyUserSignedIn(UserSignedIn $event): void
    {
        // When we will add Event Sourcing support we will record UserSignedIn event to the Event Store
        // But for now we will just update updated_at and logged_at fields
        $now = DateTime::now();
        $this->setUpdatedAt($now);
        $this->setLoggedAt($now);
    }

    protected function applyUserEmailChanged(UserEmailChanged $event): void
    {
        Assert::notEq(
            $this->credentials->email->toString(),
            $event->email->toString(),
            'New email should be different'
        );

        $this->setEmail($event->email);
        $this->setUpdatedAt($event->updatedAt);
    }

    public function getCredentials(): Credentials
    {
        return $this->credentials;
    }

    public function setCredentials(Credentials $credentials): void
    {
        $this->credentials = $credentials;
    }

    public function setEmail(Email $email): void
    {
        $this->getCredentials()->email = $email;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function setLoggedAt(DateTime $loggedAt): void
    {
        $this->loggedAt = $loggedAt;
    }
}
