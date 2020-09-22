<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\Event;

use Acme\Domain\Organization\ValueObject\Address;
use Acme\Domain\Shared\ValueObject\DateTime;
use Acme\Domain\Shared\ValueObject\PhoneNumber;
use Acme\Domain\User\ValueObject\Email;

final class BillingInformationWasUpdated
{
    public string $companyName;

    public Address $companyAddress;

    public PhoneNumber $phoneNumber;

    public Email $email;

    public DateTime $updatedAt;

    public function __construct(
        string $companyName,
        Email $email,
        PhoneNumber $phoneNumber,
        Address $companyAddress,
        DateTime $updatedAt
    ) {
        $this->companyName = $companyName;
        $this->email = $email;
        $this->phoneNumber = $phoneNumber;
        $this->companyAddress = $companyAddress;
        $this->updatedAt = $updatedAt;
    }
}
