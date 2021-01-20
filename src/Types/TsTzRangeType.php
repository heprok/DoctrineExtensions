<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

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
        dd($value);
        return (null === $value) ? null : DateRange::toString($value);
    }

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        dd($value);
        if (null !== $value) {
            if (false == preg_match('/^(\[|\()(\d{4})-(\d{2})-(\d{2}),(\d{4})-(\d{2})-(\d{2})(\]|\))$/', $value)) {
                throw ConversionException::conversionFailedFormat(
                    $value,
                    $this->getName(),
                    '(\[|\()(\d{4})-(\d{2})-(\d{2}),(\d{4})-(\d{2})-(\d{2})(\]|\))$'
                );
            }

            $value = DateRange::fromString($value);
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
