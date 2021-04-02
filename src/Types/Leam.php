<?php

namespace DoctrineExtensions\Types;

class Leam
{
  public function __construct(public int $length, public int $amount)
  {
  }

  public function __toString()
  {
    return "($this->length,$this->amount)";
  }

  public function getCount(): int
  {
    return $this->amount;
  }

  public function setCount(int $amount): self
  {
    $this->amount = $amount;

    return $this;
  }

  public function getLength(): int
  {
    return $this->length;
  }

  public function setLength(int $length): self
  {
    $this->length = $length;

    return $this;
  }
}
