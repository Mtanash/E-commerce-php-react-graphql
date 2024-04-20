<?php

namespace queries;

use GraphQL\Type\Definition\Type;
use types\Category as CategoryType;

class Category
{
  public static function get()
  {
    return [
      'type' => CategoryType::get(),
      'args' => [
        'name' => Type::nonNull(Type::string()),
      ],
      'resolve' => function ($root, $args, $context) {
        return $context->get('repository')->get('category')->get($args['name']);
      }
    ];
  }
}
