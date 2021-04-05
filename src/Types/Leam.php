<?php

namespace DoctrineExtensions\Types;

class Leam
{
  public function __construct(
    public int $length,
    public int $amount
  ) {
  }

  public function __toString() : string
  {
    return "($this->length,$this->amount)";
  }
}
