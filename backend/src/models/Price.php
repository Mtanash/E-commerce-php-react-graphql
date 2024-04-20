<?php

namespace models;

use classes\LoggerFactory;
use models\Currency;
use models\AbstractPrice;

class Price extends AbstractPrice
{
  /**
   * @var float
   */
  protected $amount;

  /**
   * @var Currency
   */
  protected $currency;

  public function __construct($currency, $amount)
  {
    $this->setCurrency($currency);
    $this->amount = $amount;
  }

  public function getAmount(): float
  {
    return $this->amount;
  }

  public function getCurrency(): object
  {
    return $this->currency;
  }

  /**
   * Sets the currency for the object.
   *
   * @param mixed $currency The currency to set. It can be an instance of the Currency class, an array with 'label' and 'symbol' keys, or an object with 'label' and 'symbol' properties.
   * @throws \InvalidArgumentException If the currency parameter is neither an instance of the Currency class nor an array or object with 'label' and 'symbol' keys/properties.
   */
  public function setCurrency($currency)
  {
    if ($currency instanceof Currency) {
      $this->currency = $currency;
    } else {
      if (is_array($currency)) {
        $this->currency = new Currency($currency['label'], $currency['symbol']);
      } else if (is_object($currency)) {
        $this->currency = new Currency($currency->label, $currency->symbol);
      } else {
        throw new \InvalidArgumentException('Currency must be an object or an array');
      }
    }
  }
}
