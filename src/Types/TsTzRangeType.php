<?php

namespace DoctrineExtensions\Types;

use DateInterval;
use DatePeriod;
use DateTime;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;
use Salamek\DateRange;

class TsTzRangeType extends StringType
{
    const DATERANGE = 'tstzrange';

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        // dump($value);
        if (null !== $value) {
            if (false == preg_match(DatePeriodRange::REGULAR_DATE_FROM_DB, $value)) {
                throw ConversionException::conversionFailedFormat(
                    $value,
                    $this->getName(),
                    DatePeriodRange::REGULAR_DATE_FROM_DB
                );
            }
            $value = DatePeriodRange::fromString($value);
        }

        return $value;
    }


    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return self::DATERANGE;
    }

    /**
     * @override
     * @return string
     */
    public function getName()
    {
        return self::DATERANGE;
    }
}
