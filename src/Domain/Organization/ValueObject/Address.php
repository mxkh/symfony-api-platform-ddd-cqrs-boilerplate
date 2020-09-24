<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\ValueObject;

final class Address
{
    private string $addressLine1;

    private string $addressLine2;

    private string $city;

    private string $region;

    private string $country;

    private string $zipCode;

    public function __construct(
        string $addressLine1,
        string $addressLine2,
        string $city,
        string $region,
        string $country,
        string $zipCode
    ) {
        $this->addressLine1 = $addressLine1;
        $this->addressLine2 = $addressLine2;
        $this->city = $city;
        $this->region = $region;
        $this->country = $country;
        $this->zipCode = $zipCode;
    }
}
