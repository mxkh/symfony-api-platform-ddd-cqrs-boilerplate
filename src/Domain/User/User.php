<?php

declare(strict_types=1);

namespace Acme\Domain\User;

use Acme\Domain\AggregateRootBehaviourTrait;
use Acme\Domain\AggregateRootInterface;
use Acme\Domain\Organization\Organization;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\User\Event\OrganizationHasBeenAssigned;
use Acme\Domain\User\Event\UserRoleChanged;
use Acme\Domain\User\Event\UserEmailChanged;
use Acme\Domain\User\Event\UserSignedIn;
use Acme\Domain\User\Event\UserWasCreated;
use Acme\Domain\User\Event\UserWasCreatedInOrganization;
use Acme\Domain\User\Exception\InvalidCredentialsException;
use Acme\Domain\User\Specification\Checker\CustomerEmailUniquenessCheckerInterface;
use Acme\Domain\User\Specification\Rule\CustomerEmailMustBeUniqueRule;
use Acme\Domain\User\ValueObject\Auth\Credentials;
use Acme\Domain\User\ValueObject\Email;
use Acme\Domain\User\ValueObject\Role;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\Expr\Comparison;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

final class User implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private Credentials $credentials;

    /** @var Collection|UserRole[] */
    private Collection $userRoles;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    private DateTime $loggedAt;

    public function __construct()
    {
        $this->userRoles = new ArrayCollection();
    }

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

    public static function createInOrganization(
        UuidInterface $uuid,
        Credentials $credentials,
        Organization $organization,
        CustomerEmailUniquenessCheckerInterface $customerEmailUniquenessChecker
    ): self {
        static::checkRule(new CustomerEmailMustBeUniqueRule($customerEmailUniquenessChecker, $credentials->email));

        $user = new static();
        $user->addDomainEvent(new UserWasCreatedInOrganization($uuid, $credentials, $organization, DateTime::now()));

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

    public function assignOrganization(Organization $organization, Role $role): void
    {
        //todo: must check if organization has been assigned already
        $this->addDomainEvent(new OrganizationHasBeenAssigned($organization, $role, DateTime::now()));
    }

    public function changeUserRole(Organization $organization, Role $role): void
    {
        $this->addDomainEvent(new UserRoleChanged($organization, $role, DateTime::now()));
    }

    protected function applyUserWasCreated(UserWasCreated $event): void
    {
        $this->uuid = $event->uuid;

        $this->setCredentials($event->credentials);
        $this->setCreatedAt($event->createdAt);
    }

    protected function applyUserWasCreatedInOrganization(UserWasCreatedInOrganization $event): void
    {
        $this->uuid = $event->uuid;

        $this->setCredentials($event->credentials);

        $userRole = new UserRole();
        $userRole->setRole(Role::create());
        $userRole->setOrganization($event->organization);
        $userRole->setUser($this);

        $this->userRoles->add($userRole);

        $this->setCreatedAt($event->createdAt);
        $this->setUpdatedAt($event->createdAt);
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

    protected function applyUserRoleChanged(UserRoleChanged $event): void
    {
        //todo: complete this event
        $this->changeUserRoleInOrganization($event->organization, $event->role);
        $this->setUpdatedAt($event->updatedAt);
    }

    protected function applyOrganizationHasBeenAssigned(OrganizationHasBeenAssigned $event): void
    {
        $userRole = new UserRole();
        $userRole->setRole($event->role);
        $userRole->setOrganization($event->organization);
        $userRole->setUser($this);

        $this->userRoles->add($userRole);

        $this->setUpdatedAt($event->updatedAt);
    }

    protected function changeUserRoleInOrganization(Organization $organization, Role $role): void
    {
        $criteria = Criteria::create()
            ->where(new Comparison('organization', Comparison::EQ, $organization));

        $result = $this->userRoles->matching($criteria);

        if (0 === $result->count()) {
            throw new InvalidCredentialsException(/* todo: User is not a member of the organization */);
        }

        if (1 === $result->count()) {
            /** @var UserRole $userRole */
            $userRole = $result->first();
            $userRole->setRole($role);

            return;
        }

        throw new InvalidCredentialsException(/* todo: something wen't wrong */);
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
