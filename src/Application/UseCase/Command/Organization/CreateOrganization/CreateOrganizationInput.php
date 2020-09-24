<?php

declare(strict_types=1);

namespace Acme\Application\UseCase\Command\Organization\CreateOrganization;

use Symfony\Component\Validator\Constraints as Assert;

final class CreateOrganizationInput
{
    /**
     * @Assert\Uuid
     * @Assert\NotBlank
     */
    public string $uuid;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     */
    public string $name;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    public string $description;

    /**
     * @Assert\Type(type="string")
     * @Assert\NotNull
     */
    public string $shortDescription;

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
}
