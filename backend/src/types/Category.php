<?php

namespace types;

use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Category as CategoryModel;

class Category extends ObjectType
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
      'name' => 'Category',
      'fields' => function () {
        return [
          'name' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Name of the category',
            'resolve' => function (CategoryModel $category) {
              return $category->getName();
            }
          ],
        ];
      }
    ]);
  }
}
