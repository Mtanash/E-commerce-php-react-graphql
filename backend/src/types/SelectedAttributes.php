<?php

namespace types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;

class SelectedAttributes
{
  public static function get()
  {
    return new InputObjectType([
      'name' => 'SelectedAttributes',
      'fields' => [
        'id' => [
          'type' => Type::nonNull(Type::string()),
          'description' => 'ID of the attribute',
        ],
        'value' => [
          'type' => Type::nonNull(Type::string()),
          'description' => 'ID of attribute value',
        ]
      ],
    ]);
  }
}
