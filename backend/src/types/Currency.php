<?php

namespace types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Currency as CurrencyModel;

class Currency extends ObjectType
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
      'name' => 'Currency',
      'fields' => function () {
        return [
          'label' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Label of the currency',
            'resolve' => function (CurrencyModel $currency) {
              return $currency->getLabel();
            }
          ],
          'symbol' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Symbol of the currency',
            'resolve' => function (CurrencyModel $currency) {
              return $currency->getSymbol();
            }
          ]
        ];
      }
    ]);
  }
}
