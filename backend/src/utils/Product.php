<?php

namespace utils;

class Product
{
  /**
   * Validates a product object.
   * 
   * @param object $product The product object to validate.
   * @return bool True if the product is valid, false otherwise.
   */
  public static function validateProduct($product): bool
  {
    if (is_object($product)) {
      return (
        isset($product->id, $product->name, $product->inStock, $product->gallery, $product->description, $product->category, $product->attributes, $product->prices, $product->brand) &&
        is_string($product->id) &&
        is_string($product->name) &&
        is_bool($product->inStock) &&
        is_array($product->gallery) &&
        is_string($product->description) &&
        is_string($product->category) &&
        is_array($product->attributes) &&
        is_array($product->prices) &&
        is_string($product->brand)
      );
    } else if (is_array($product)) {
      return (
        isset($product["id"], $product["name"], $product["inStock"], $product["gallery"], $product["description"], $product["category"], $product["attributes"], $product["prices"], $product["brand"]) &&
        is_string($product["id"]) &&
        is_string($product["name"]) &&
        is_bool($product["inStock"]) &&
        is_array($product["gallery"]) &&
        is_string($product["description"]) &&
        is_string($product["category"]) &&
        is_array($product["attributes"]) &&
        is_array($product["prices"]) &&
        is_string($product["brand"])
      );
    }
    return false;
  }
}
