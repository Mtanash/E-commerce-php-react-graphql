<?php

namespace mutations;

use GraphQL\Type\Definition\InputObjectField;
use GraphQL\Type\Definition\Type;
use types\CartProduct;
use types\Order as OrderType;
use types\CurrencyInput as CurrencyInputType;
use models\Order as OrderModel;


class Order
{

  public static function get()
  {
    return [
      'type' => OrderType::get(),
      'args' => [
        'products' => Type::nonNull(Type::listOf(CartProduct::get())),
        'total' => Type::nonNull(Type::float()),
        'currency' => CurrencyInputType::get(),
      ],
      'resolve' => function ($root, array $args, $context) {
        $order = new OrderModel(
          $args['products'],
          $args['total'],
          $args['currency'],
        );
        return $context->get('repository')->get('order')->create($order);
      }
    ];
  }
}
