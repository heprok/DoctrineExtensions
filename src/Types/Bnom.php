<?php

namespace DoctrineExtensions\Types;

class Bnom
{
  public function __construct(
    private int $thickness,
    private int $width
  ) {
  }

  public function __toString()
  {
    return "($this->thickness,$this->width)";
  }

  public function getCut(): string
  {
    return  $this->thickness . '⨯' . $this->width;
  }

  public function getWidth(): int
  {
    return $this->width;
  }

  public function setWidth(int $width): self
  {
    $this->width = $width;

    return $this;
  }

  public function getThickness(): int
  {
    return $this->thickness;
  }

  public function setThickness(int $thickness): self
  {
    $this->thickness = $thickness;

    return $this;
  }
}
