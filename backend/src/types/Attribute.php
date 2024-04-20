<?php

namespace types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Attribute as AttributeModel;

class Attribute extends ObjectType
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
      'name' => 'Attribute',
      'fields' => function () {
        return [
          'id' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'ID of the attribute',
            'resolve' => function (AttributeModel $attribute) {
              return $attribute->getId();
            }
          ],
          'value' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Value of the attribute',
            'resolve' => function (AttributeModel $attribute) {
              return $attribute->getValue();
            }
          ],
          'displayValue' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Display value of the attribute',
            'resolve' => function (AttributeModel $attribute) {
              return $attribute->getDisplayValue();
            }
          ]
        ];
      }
    ]);
  }
}
