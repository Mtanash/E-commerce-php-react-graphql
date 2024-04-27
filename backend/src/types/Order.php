<?php

namespace types;

use classes\LoggerFactory;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Order as OrderModel;
use types\Currency as CurrencyType;

class Order extends ObjectType
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
      'name' => 'Order',
      'fields' => [
        'id' => [
          'type' => Type::nonNull(Type::string()),
          'description' => 'ID of the order',
          'resolve' => function (OrderModel $order) {
            return $order->getOrderNumber();
          }
        ],
        'total' => [
          'type' => Type::nonNull(Type::float()),
          'description' => 'Total of the order',
          'resolve' => function (OrderModel $order) {
            return $order->getTotal();
          }
        ],
        'createdAt' => [
          'type' => Type::nonNull(Type::string()),
          'description' => 'Creation date of the order',
          'resolve' => function (OrderModel $order) {
            return $order->getCreatedAt();
          }
        ],
        'updatedAt' => [
          'type' => Type::nonNull(Type::string()),
          'description' => 'Last update date of the order',
          'resolve' => function (OrderModel $order) {
            return $order->getUpdatedAt();
          }
        ]
      ]
    ]);
  }
}
