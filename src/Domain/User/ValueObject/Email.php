<?php

declare(strict_types=1);

namespace Acme\Domain\User\ValueObject;

use Webmozart\Assert\Assert;

final class Email implements \JsonSerializable
{
    private string $email;

    private function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function fromString(string $email): self
    {
        Assert::email($email, 'Not a valid email');

        return new self($email);
    }

    public function toString(): string
    {
        return $this->email;
    }

    public function __toString(): string
    {
        return $this->email;
    }

    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
