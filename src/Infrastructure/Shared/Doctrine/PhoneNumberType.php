<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Doctrine;

use Acme\Domain\Shared\ValueObject\PhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

final class PhoneNumberType extends StringType
{
    private const TYPE = 'phone_number';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof PhoneNumber) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', PhoneNumber::class]);
        }

        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof PhoneNumber) {
            return $value;
        }

        try {
            $phoneNumber = PhoneNumber::fromString($value);
        } catch (Throwable $e) {
            throw ConversionException::conversionFailedFormat($value, $this->getName(),
                $platform->getDateTimeFormatString());
        }

        return $phoneNumber;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return true;
    }

    public function getName()
    {
        return self::TYPE;
    }
}
