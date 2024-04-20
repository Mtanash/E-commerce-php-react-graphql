<?php

namespace models;

use models\AbstractAttribute;

class Attribute extends AbstractAttribute
{
  /**
   * @var string
   */
  protected $id;

  /**
   * @var string
   */
  protected $value;

  /**
   * @var string
   */
  protected $displayValue;

  public function __construct(
    $id,
    $value,
    $displayValue
  ) {
    $this->id = $id;
    $this->value = $value;
    $this->displayValue = $displayValue;
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function getValue(): string
  {
    return $this->value;
  }

  public function getDisplayValue(): string
  {
    return $this->displayValue;
  }
}
