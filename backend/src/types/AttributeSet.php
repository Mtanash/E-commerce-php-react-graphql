<?php

namespace types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\AttributeSet as AttributeSetModel;
use types\Attribute as AttributeType;

class AttributeSet extends ObjectType
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
      'name' => 'AttributeSet',
      'fields' => function () {
        return [
          'id' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'ID of the attribute set',
            'resolve' => function (AttributeSetModel $attributeSet) {
              return $attributeSet->getId();
            }
          ],
          'name' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Name of the attribute set',
            'resolve' => function (AttributeSetModel $attributeSet) {
              return $attributeSet->getName();
            }
          ],
          'type' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Type of the attribute set',
            'resolve' => function (AttributeSetModel $attributeSet) {
              return $attributeSet->getType();
            }
          ],
          'items' => [
            'type' => Type::listOf(AttributeType::get()),
            'description' => 'Items of the attribute set',
            'resolve' => function (AttributeSetModel $attributeSet) {
              return $attributeSet->getItems();
            }
          ]
        ];
      },

    ]);
  }
}
