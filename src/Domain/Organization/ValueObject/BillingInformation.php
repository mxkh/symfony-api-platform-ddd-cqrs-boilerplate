<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\ValueObject;

use Acme\Domain\Shared\ValueObject\PhoneNumber;
use Acme\Domain\User\ValueObject\Email;

final class BillingInformation
{
    private string $companyName;

    private Address $companyAddress;

    private PhoneNumber $phoneNumber;

    private Email $email;

    public function __construct(
        string $companyName,
        Address $companyAddress,
        PhoneNumber $phoneNumber,
        Email $email
    ) {
        $this->companyName = $companyName;
        $this->companyAddress = $companyAddress;
        $this->phoneNumber = $phoneNumber;
        $this->email = $email;
    }
}
