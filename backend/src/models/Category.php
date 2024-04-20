<?php

namespace models;

class Category extends AbstractCategory
{

  protected $name;

  public function __construct($name)
  {
    $this->name = $name;
  }

  public function getName(): string
  {
    return $this->name;
  }
}
