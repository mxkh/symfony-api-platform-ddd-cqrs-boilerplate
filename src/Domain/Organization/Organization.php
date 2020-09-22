<?php

declare(strict_types=1);

namespace Acme\Domain\Organization;

use Acme\Domain\AggregateRootBehaviourTrait;
use Acme\Domain\AggregateRootInterface;
use Acme\Domain\Organization\Event\BillingInformationWasUpdated;
use Acme\Domain\Organization\Event\OrganizationWasCreated;
use Acme\Domain\Organization\ValueObject\BillingInformation;
use Acme\Domain\Organization\ValueObject\OrganizationProfile;
use Acme\Domain\Organization\ValueObject\Address;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\Shared\ValueObject\PhoneNumber;
use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\UuidInterface;

final class Organization implements AggregateRootInterface
{
    use AggregateRootBehaviourTrait;

    private OrganizationProfile $profile;

    private BillingInformation $billingInformation;

    private Address $address;

    private DateTime $createdAt;

    private DateTime $updatedAt;

    public static function create(
        UuidInterface $uuid,
        OrganizationProfile $organizationProfile,
        Address $address
    ): self {
        $organization = new static();
        $organization->addDomainEvent(
            new OrganizationWasCreated($uuid, $organizationProfile, $address, DateTime::now())
        );

        return $organization;
    }

    public function updateBillingInformation(
        string $companyName,
        Email $email,
        PhoneNumber $phoneNumber,
        Address $address
    ): void {
        $this->addDomainEvent(
            new BillingInformationWasUpdated($companyName, $email, $phoneNumber, $address, DateTime::now())
        );
    }

    protected function applyOrganizationWasCreated(OrganizationWasCreated $event): void
    {
        $this->uuid = $event->uuid;
        $this->profile = $event->profile;
        $this->address = $event->address;
        $this->createdAt = $event->createdAt;
        $this->updatedAt = $event->createdAt;
    }

    protected function applyBillingInformationWasUpdated(BillingInformationWasUpdated $event): void
    {
        $this->billingInformation = new BillingInformation(
            $event->companyName, $event->companyAddress, $event->phoneNumber, $event->email
        );
        $this->updatedAt = $event->updatedAt;
    }
}
