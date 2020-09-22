<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\UpdateBillingInformation;

use Symfony\Component\Validator\Constraints as Assert;

final class UpdateBillingInformationInput
{
    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $companyName;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $addressLine1;
    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    public string $addressLine2;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $city;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $region;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $country;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $zipCode;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $phoneNumber;

    /**
     * @Assert\Email
     * @Assert\NotBlank
     */
    public string $email;
}
