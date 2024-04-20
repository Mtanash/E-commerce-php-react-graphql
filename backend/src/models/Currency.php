<?php

namespace models;

use models\AbstractCurrency;

class Currency extends AbstractCurrency
{

  /**
   * @var string
   */
  protected $label;

  /**
   * @var string
   */
  protected $symbol;

  public function __construct($label, $symbol)
  {
    $this->label = $label;
    $this->symbol = $symbol;
  }

  public function getLabel(): string
  {
    return $this->label;
  }

  public function getSymbol(): string
  {
    return $this->symbol;
  }
}
