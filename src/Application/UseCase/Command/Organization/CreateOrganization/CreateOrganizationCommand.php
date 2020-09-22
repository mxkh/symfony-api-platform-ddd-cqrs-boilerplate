<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\CreateOrganization;

use Acme\Domain\Organization\ValueObject\Address;
use Acme\Domain\Organization\ValueObject\BillingInformation;
use Acme\Domain\Organization\ValueObject\OrganizationProfile;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class CreateOrganizationCommand
{
    private UuidInterface $uuid;

    private OrganizationProfile $profile;

    private Address $address;

    public function __construct(
        string $uuid,
        string $name,
        string $description,
        string $shortDescription,
        string $addressLine1,
        string $addressLine2,
        string $city,
        string $region,
        string $country,
        string $zipCode
    ) {
        $this->uuid = Uuid::fromString($uuid);
        $this->profile = new OrganizationProfile($name, $description, $shortDescription);
        $this->address = new Address($addressLine1, $addressLine2, $city, $region, $country, $zipCode);
    }

    public function uuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function profile(): OrganizationProfile
    {
        return $this->profile;
    }

    public function address(): Address
    {
        return $this->address;
    }
}
