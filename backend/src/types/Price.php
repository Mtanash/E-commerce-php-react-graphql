<?php

namespace types;

use classes\LoggerFactory;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Price as PriceModel;
use types\Currency as CurrencyType;

class Price extends ObjectType
{
  static $type = null;

  public static function get()
  {
    if (self::$type === null) {
      self::$type = self::create();
    }
    return self::$type;
  }

  private static function create()
  {
    return new ObjectType([
      'name' => 'Price',
      'fields' => function () {
        return [
          'amount' => [
            'type' => Type::nonNull(Type::float()),
            'description' => 'Amount of the price',
            'resolve' => function (PriceModel $price) {
              return $price->getAmount();
            }
          ],
          'currency' => [
            'type' => CurrencyType::get(),
            'description' => 'Currency of the price',
            'resolve' => function (PriceModel $price) {
              return $price->getCurrency();
            }
          ]
        ];
      }
    ]);
  }
}
