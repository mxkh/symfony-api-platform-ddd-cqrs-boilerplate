<?php

declare(strict_types=1);

namespace Acme\Domain\User\ValueObject;

use Webmozart\Assert\Assert;

final class Role
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_USER = 'ROLE_USER';

    public const ROLES = [
        self::ROLE_ADMIN,
        self::ROLE_USER,
    ];

    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function create(): self
    {
        return self::fromString(self::ROLE_USER);
    }

    public static function fromString(string $name): self
    {
        Assert::inArray($name, self::ROLES);

        return new self($name);
    }

    public function toString(): string
    {
        return $this->name;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
