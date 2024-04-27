<?php

namespace types;

use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Type\Definition\Type;
use types\SelectedAttributes as SelectedAttributesType;

class CartProduct
{
  public static function get()
  {
    return new InputObjectType([
      'name' => 'CartProduct',
      'fields' => function () {
        return [
          'id' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'ID of the product',
          ],
          'quantity' => [
            'type' => Type::nonNull(Type::int()),
            'description' => 'Quantity of the product in the cart',
          ],
          'selectedAttributes' => [
            'type' => Type::nonNull(Type::listOf(SelectedAttributesType::get())),
            'description' => 'Selected attributes of the product',
          ]
        ];
      }
    ]);
  }
}
