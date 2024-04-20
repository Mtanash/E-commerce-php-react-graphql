<?php

namespace repositories;

use Psr\Log\LoggerInterface;
use repositories\ProductRepositoryInterface;
use errors\NotFound;
use models\Product as ProductModel;
use utils\Product as ProductUtils;

class ProductRepository implements ProductRepositoryInterface
{

  protected $pdo;

  protected $logger;

  public function __construct($pdo, LoggerInterface $logger)
  {
    $this->pdo = $pdo;
    $this->logger = $logger;
  }

  public function get(string $id): ProductModel
  {
    try {

      $this->logger->info('ProductRepository->get', ['id' => $id]);

      $sql = 'SELECT * FROM Product WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute(['id' => $id]);

      if ($stmt->rowCount() === 0) {
        $this->logger->error('Product not found!' . $id);
        throw new NotFound('Product not found!');
      }

      $product = $stmt->fetch(\PDO::FETCH_ASSOC);

      $this->logger->info('ProductRepository->get', ['product' => print_r($product, true)]);

      return new ProductModel(
        $product['id'],
        $product['name'],
        $product['inStock'],
        $product['gallery'],
        $product['description'],
        $product['category'],
        $product['attributes'],
        $product['prices'],
        $product['brand']
      );
    } catch (\Exception $e) {
      $this->logger->error('ProductRepository->get', ['error' => $e->getMessage()]);
      throw $e;
    }
  }

  public function getAll(): array
  {
    try {

      $this->logger->info('ProductRepository->getAll');

      $sql = 'SELECT * FROM Product';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();

      $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($products as $key => $product) {
        $products[$key] = new ProductModel(
          $product['id'],
          $product['name'],
          $product['inStock'],
          $product['gallery'],
          $product['description'],
          $product['category'],
          $product['attributes'],
          $product['prices'],
          $product['brand']
        );
      }

      return $products;
    } catch (\Exception $e) {
      $this->logger->error('ProductRepository->getAll', ['error' => $e->getMessage()]);
      throw $e;
    }
  }

  public function create($product): ProductModel
  {
    try {
      if (!ProductUtils::validateProduct($product)) {
        $this->logger->error('Invalid product data!');
        throw new \Exception('Invalid product data!');
      }

      if (is_object($product)) {
        $newProduct = new ProductModel(
          $product->id,
          $product->name,
          $product->inStock,
          $product->gallery,
          $product->description,
          $product->category,
          $product->attributes,
          $product->prices,
          $product->brand
        );
      } else {
        $newProduct = new ProductModel(
          $product['id'],
          $product['name'],
          $product['inStock'],
          $product['gallery'],
          $product['description'],
          $product['category'],
          $product['attributes'],
          $product['prices'],
          $product['brand']
        );
      }

      $this->logger->info('ProductRepository->create', ['product' => print_r($newProduct->getId(), true)]);

      $stmt = $this->pdo->prepare('INSERT INTO Product (id, name, inStock, gallery, description, category, attributes, prices, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');

      $stmt->execute([
        $newProduct->getId(),
        $newProduct->getName(),
        $newProduct->isInStock(),
        json_encode($newProduct->getGallery()),
        $newProduct->getDescription(),
        $newProduct->getCategory()->getName(),
        json_encode($newProduct->getAttributes()),
        json_encode($newProduct->getPrices()),
        $newProduct->getBrand()
      ]);

      return $newProduct;
    } catch (\Exception $e) {
      $this->logger->error('ProductRepository->create', ['error' => $e->getMessage()]);
      throw $e;
    }
  }

  public function getByCategory(string $category): array
  {
    try {

      $this->logger->info('ProductRepository->getByCategory', ['category' => $category]);

      $sql = 'SELECT * FROM Product WHERE category = ?';

      $stmt = $this->pdo->prepare($sql);

      $stmt->execute([$category]);

      $products = $stmt->fetchAll(\PDO::FETCH_ASSOC);

      foreach ($products as $key => $product) {
        $products[$key] = new ProductModel(
          $product['id'],
          $product['name'],
          $product['inStock'],
          $product['gallery'],
          $product['description'],
          $product['category'],
          $product['attributes'],
          $product['prices'],
          $product['brand']
        );
      }

      return $products;
    } catch (\Exception $e) {
      $this->logger->error('ProductRepository->getByCategory', ['error' => $e->getMessage()]);
      throw $e;
    }
  }
}
