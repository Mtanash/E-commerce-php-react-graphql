<?php

namespace queries;

use GraphQL\Type\Definition\Type;
use types\Product as ProductType;

class Product
{
  public static function get()
  {
    return [
      'type' => ProductType::get(),
      'args' => [
        'id' => Type::nonNull(Type::string()),
      ],
      'resolve' => function ($root, array $args, $context) {
        $id = $args['id'];
        return $context->get('repository')->get('product')->get($id);
      }
    ];
  }
}
