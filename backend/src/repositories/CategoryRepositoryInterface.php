<?php

namespace repositories;

use models\Category as CategoryModel;

interface CategoryRepositoryInterface
{
  /**
   * Retrieves a category from the database based on the given name.
   *
   * @param string $name The name of the category to retrieve.
   * @throws NotFound If the category with the given name is not found in the database.
   * @return CategoryModel The retrieved category.
   */
  public function get(string $name): CategoryModel;

  /**
   * Retrieves all categories from the database.
   *
   * @return CategoryModel[] An array of CategoryModel objects representing the categories.
   * @throws \Exception If an error occurs while retrieving the categories.
   */
  public function getAll(): array;

  /**
   * Creates a new category in the database.
   * 
   * @param object $category The category object to create.
   * @throws \Exception If an error occurs while creating the category.
   * @return CategoryModel The created category.
   */
  public function create(object $category): CategoryModel;
}
