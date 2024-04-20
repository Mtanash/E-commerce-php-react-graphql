<?php

namespace types;

use classes\LoggerFactory;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use models\Product as ProductModel;
use types\Price as PriceType;
use types\AttributeSet as AttributeSetType;
use types\Category as CategoryType;

class Product extends ObjectType
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
      'name' => 'Product',
      'fields' => function () {
        return [
          'id' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'ID of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getId();
            }
          ],
          'name' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Name of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getName();
            }
          ],
          'inStock' => [
            'type' => Type::nonNull(Type::boolean()),
            'description' => 'Is the product in stock?',
            'resolve' => function (ProductModel $product) {
              return $product->isInStock();
            }
          ],
          'gallery' => [
            'type' => Type::listOf(Type::string()),
            'description' => 'Gallery of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getGallery();
            }
          ],
          'description' => [
            'type' => Type::string(),
            'description' => 'Description of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getDescription();
            }
          ],
          'category' => [
            'type' => CategoryType::get(),
            'description' => 'Category of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getCategory();
            }
          ],
          'attributes' => [
            'type' => Type::listOf(AttributeSetType::get()),
            'description' => 'Attributes of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getAttributes();
            }
          ],
          'prices' => [
            'type' => Type::listOf(PriceType::get()),
            'description' => 'Prices of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getPrices();
            }
          ],
          'brand' => [
            'type' => Type::nonNull(Type::string()),
            'description' => 'Brand of the product',
            'resolve' => function (ProductModel $product) {
              return $product->getBrand();
            }
          ]
        ];
      }
    ]);
  }
}
