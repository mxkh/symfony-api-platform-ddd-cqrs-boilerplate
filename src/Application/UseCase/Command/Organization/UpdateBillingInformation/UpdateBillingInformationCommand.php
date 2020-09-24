<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\UpdateBillingInformation;

use Acme\Domain\Organization\ValueObject\Address;
use Acme\Domain\Shared\ValueObject\PhoneNumber;
use Acme\Domain\User\ValueObject\Email;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class UpdateBillingInformationCommand
{
    private UuidInterface $organizationUuid;

    private string $companyName;

    private Email $email;

    private PhoneNumber $phoneNumber;

    private Address $address;

    public function __construct(
        string $organizationUuid,
        string $companyName,
        string $addressLine1,
        string $addressLine2,
        string $city,
        string $region,
        string $country,
        string $zipCode,
        string $phoneNumber,
        string $email
    ) {
        $this->organizationUuid = Uuid::fromString($organizationUuid);
        $this->email = Email::fromString($email);
        $this->phoneNumber = PhoneNumber::fromString($phoneNumber);
        $this->companyName = $companyName;
        $this->address = new Address($addressLine1, $addressLine2, $city, $region, $country, $zipCode);
    }

    public function organizationUuid(): UuidInterface
    {
        return $this->organizationUuid;
    }

    public function companyName(): string
    {
        return $this->companyName;
    }

    public function email(): Email
    {
        return $this->email;
    }

    public function phoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function address(): Address
    {
        return $this->address;
    }
}
