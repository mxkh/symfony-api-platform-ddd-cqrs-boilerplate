<?php

declare(strict_types=1);

namespace Acme\Infrastructure\Shared\Doctrine;

use Acme\Domain\User\ValueObject\Role;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Throwable;

final class RoleType extends StringType
{
    private const TYPE = 'role';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return null;
        }

        if (!$value instanceof Role) {
            throw ConversionException::conversionFailedInvalidType($value, $this->getName(), ['null', Role::class]);
        }

        return $value->toString();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (null === $value || $value instanceof Role) {
            return $value;
        }

        try {
            $phoneNumber = Role::fromString($value);
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
