<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\Event;

use Acme\Domain\Organization\ValueObject\Address;
use Acme\Domain\Organization\ValueObject\OrganizationProfile;
use Acme\Domain\Shared\ValueObject\DateTime;
use Ramsey\Uuid\UuidInterface;

final class OrganizationWasCreated
{
    public UuidInterface $uuid;

    public OrganizationProfile $profile;

    public Address $address;

    public DateTime $createdAt;

    public function __construct(
        UuidInterface $uuid,
        OrganizationProfile $profile,
        Address $address,
        DateTime $createdAt
    ) {
        $this->uuid = $uuid;
        $this->profile = $profile;
        $this->address = $address;
        $this->createdAt = $createdAt;
    }
}
