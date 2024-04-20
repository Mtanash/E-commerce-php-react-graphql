<?php

namespace queries;

use GraphQL\Type\Definition\Type;
use types\Category;

class Categories
{
  public static function get()
  {
    return [
      'type' => Type::listOf(Type::nonNull(Category::get())),
      'resolve' => function ($root, $args, $context) {
        return $context->get('repository')->get('category')->getAll();
      }
    ];
  }
}
