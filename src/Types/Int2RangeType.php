<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class Int2RangeType extends StringType
{
    const INT2RANGE = 'int2range';

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @return mixed|null
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        // dd($value);
        return sprintf('[%s, %s)', min($value,), max($value));
        
    }

    /**
     * @override
     * @param mixed $value
     * @param AbstractPlatform $platform
     * @throws ConversionException
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $reg = '/(?\'includefirst\'\[|\()(?\'first\'\d+),(?\'second\'\d+)(?\'includesecond\'\]|\))/';
        $str = '[20,40)';
        if ($value && preg_match($reg, $value, $matches)) {
            $first = (int)$matches['first'];
            $second = (int)$matches['second'];
            $matches['includefirst'] == ')' ? $first-- : $first;
            $matches['includesecond'] == ')' ? $second-- : $second;
            return range($first, $second);
        }else {
            throw ConversionException::conversionFailedFormat($value, $this->getName(), $reg);
        }

    }


    public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return self::INT2RANGE;
    }

    /**
     * @override
     * @return string
     */
    public function getName()
    {
        return self::INT2RANGE;
    }
}
