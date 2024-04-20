<?php

namespace repositories;

use models\Product as ProductModel;

interface ProductRepositoryInterface
{
  /**
   * Retrieves a product from the database based on the given ID.
   *
   * @param string $id The ID of the product to retrieve.
   * @throws NotFound If the product with the given ID is not found in the database.
   * @return ProductModel The retrieved product.
   */
  public function get(string $id): ProductModel;

  /**
   * Retrieves all products from the database.
   *
   * @return ProductModel[] An array of ProductModel objects representing the products.
   * @throws \Exception If an error occurs while retrieving the products.
   */
  public function getAll(): array;

  /**
   * Retrieves all products from the database that belong to the given category.
   * 
   * @param string $category The category of the products to retrieve.
   * @return ProductModel[] An array of ProductModel objects representing the products.
   * @throws \Exception If an error occurs while retrieving the products.
   */
  public function getByCategory(string $category): array;

  /**
   * Creates a new product in the database.
   * 
   * @param $product The product object or array to create.
   * @throws \Exception If an error occurs while creating the product.
   * @return ProductModel The created product.
   */
  public function create($product): ProductModel;
}
