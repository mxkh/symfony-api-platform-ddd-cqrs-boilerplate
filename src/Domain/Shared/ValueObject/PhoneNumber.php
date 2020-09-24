<?php

declare(strict_types=1);

namespace Acme\Domain\Shared\ValueObject;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

final class PhoneNumber
{
    private string $phoneNumber;

    private function __construct(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }

    public static function fromString(string $phoneNumber): self
    {
        $util = PhoneNumberUtil::getInstance();
        try {
            $phoneNumberObject = $util->parse($phoneNumber);
        } catch (NumberParseException $e) {
            throw new \InvalidArgumentException('Not a valid phone number');
        }

        return new self($util->format($phoneNumberObject, PhoneNumberFormat::E164));
    }

    public function toString(): string
    {
        return $this->phoneNumber;
    }

    public function __toString(): string
    {
        return $this->phoneNumber;
    }
}
