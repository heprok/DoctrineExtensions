<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class LeamType extends Type
{
  const LEAM_TYPE = 'leam';

  public function convertToDatabaseValue($value, AbstractPlatform $platform)
  {
    return sprintf('[%s, $s]', $value->length, $value->amount);
  }

  public function convertToPHPValue($value, AbstractPlatform $platform) : Leam
  {
    [$length, $amount] = explode(',', str_replace(['[', ']'], '', $value));
    return new Leam($length, $amount);
  }

  public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
  {
    return self::LEAM_TYPE;
  }

  public function getName()
  {
    return self::LEAM_TYPE;
  }
}