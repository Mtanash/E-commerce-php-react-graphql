<?php

namespace types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class CurrencyInput
{

  public static function get()
  {
    return new InputObjectType([
      'name' => 'CurrencyInput',
      'fields' => function () {
        return [
          'label' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Label of the currency',
          ],
          'symbol' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Symbol of the currency',
          ]
        ];
      }
    ]);
  }
}
