<?php

namespace repositories;

use Psr\Log\LoggerInterface;
use repositories\CategoryRepositoryInterface;
use errors\NotFound;
use models\Category as CategoryModel;

class CategoryRepository implements CategoryRepositoryInterface
{

  protected $pdo;

  protected $logger;

  public function __construct($pdo, LoggerInterface $logger)
  {
    $this->pdo = $pdo;
    $this->logger = $logger;
  }

  public function get(string $name): CategoryModel
  {
    try {

      $this->logger->info('CategoryRepository->get', ['name' => $name]);

      $sql = 'SELECT * FROM Category WHERE name = :name';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['name' => $name]);

      if ($stmt->rowCount() === 0) {
        $this->logger->error('Category not found!' . $name);
        throw new NotFound('Category not found!');
      }

      $category = $stmt->fetch(\PDO::FETCH_ASSOC);

      return new CategoryModel(
        $category['name']
      );
    } catch (\Exception $e) {
      $this->logger->error('CategoryRepository->get', ['error' => $e->getMessage()]);
      throw $e;
    }
  }

  public function getAll(): array
  {
    try {

      $this->logger->info('CategoryRepository->getAll');

      $sql = 'SELECT * FROM Category';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();

      $categories = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($categories as $key => $category) {
        $categories[$key] = new CategoryModel(
          $category['name']
        );
      }

      return $categories;
    } catch (\Exception $e) {
      $this->logger->error('CategoryRepository->getAll', ['error' => $e->getMessage()]);
      throw $e;
    }
  }

  public function create(object $category): CategoryModel
  {
    try {
      $this->logger->info('CategoryRepository->create', ['category' => $category->name]);

      $newCategory = new CategoryModel($category->name);

      $sql = 'INSERT INTO Category (name) VALUES (?)';

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute([$newCategory->getName()]);

      return $newCategory;
    } catch (\Exception $e) {
      $this->logger->error('CategoryRepository->create', ['error' => $e->getMessage()]);
      throw $e;
    }
  }
}
