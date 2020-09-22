<?php

declare(strict_types=1);

namespace Acme\Domain\Organization\ValueObject;

final class OrganizationProfile
{
    private string $name;

    private string $description;

    private string $shorDescription;

    public function __construct(
        string $name,
        string $description,
        string $shorDescription
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->shorDescription = $shorDescription;
    }
}
