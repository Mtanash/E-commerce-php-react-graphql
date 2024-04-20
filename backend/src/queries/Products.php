<?php

namespace queries;

use GraphQL\Type\Definition\Type;
use types\Product;

class Products
{
  public static function get()
  {
    return [
      'type' => Type::listOf(Type::nonNull(Product::get())),
      'args' => [
        'category' => Type::string()
      ],
      'resolve' => function ($root, $args, $context) {
        if (isset($args['category'])) {
          return $context->get('repository')->get('product')->getByCategory($args['category']);
        }
        return $context->get('repository')->get('product')->getAll();
      }
    ];
  }
}
