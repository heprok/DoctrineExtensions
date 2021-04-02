<?php

namespace DoctrineExtensions\Types;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

final class LeamArrayType extends Type
{
  const LEAM_TYPE = 'leam array';
  //{"(27,90)","(27,150)","(27,150)","(27,90)"}
  public function convertToDatabaseValue($value, AbstractPlatform $platform)
  {
    settype($value, 'array');
    $result = [];
    foreach( $value as $leam )
    {
      if ($leam instanceof Leam)
        $result[] = $leam->__toString(); // преобразует (length, amount)
    }
    return '{"' . implode('","', $result) . '"}';
  }

  public function convertToPHPValue($value, AbstractPlatform $platform) : array
  {
    $result = [];
    $arrayLeam = explode('","', trim($value, '{""}'));
    foreach($arrayLeam as $leam)
    {
      [$length, $amount] = explode(',', str_replace(['(', ')'], '', $leam));

      // dd($length, $amount, $leam);
      $result[] = new Leam($length, $amount);
    }
    return $result;
  }

  public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
  {
    return 'leam[]';
  }

  public function getName()
  {
    return self::LEAM_TYPE;
  }
}