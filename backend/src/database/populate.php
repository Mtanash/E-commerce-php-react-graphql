<?php

require __DIR__ . "/../../vendor/autoload.php";

use classes\LoggerFactory;
use database\Database;

$config = require __DIR__ . "/../config.php";

$dataJson = file_get_contents(__DIR__ . "/../data/db.json");
$data = json_decode($dataJson, true);


try {
  $logger = LoggerFactory::getLogger();
  $pdo = Database::getConnection($config, $logger);
  $pdo->beginTransaction();

  // Ensure tables exist
  createProductTable($pdo, $logger);
  createCategoryTable($pdo, $logger);

  // Populate products
  populateProducts($pdo, $data["data"]["products"], $logger);

  // Populate categories
  populateCategories($pdo, $data["data"]["categories"], $logger);

  // Commit transaction
  $pdo->commit();
  $logger->info("DB populated successfully");
} catch (PDOException $e) {
  // Rollback transaction on error
  $pdo->rollBack();
  $logger->error("DB population failed: " . $e->getMessage());
}

// Function to create product table if not exists
function createProductTable($pdo, $logger)
{
  try {

    $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS Product (
        id VARCHAR(100) PRIMARY KEY,
        name VARCHAR(255),
        inStock BOOLEAN,
        gallery TEXT,
        description TEXT,
        category VARCHAR(255),
        attributes TEXT,
        prices TEXT,
        brand VARCHAR(255)
    )");

    $stmt->execute();
    $logger->info("Product table created if not exists");
  } catch (\Exception $e) {
    $logger->error("Product table creation failed: " . $e->getMessage());
    throw $e;
  }
}

// Function to create category table if not exists
function createCategoryTable($pdo, $logger)
{
  try {
    $stmt = $pdo->prepare("CREATE TABLE IF NOT EXISTS Category (
        name VARCHAR(100) PRIMARY KEY
    )");

    $stmt->execute();
    $logger->info("Category table created if not exists");
  } catch (\Exception $e) {
    $logger->error("Category table creation failed: " . $e->getMessage());
    throw $e;
  }
}

// Function to populate products
function populateProducts($pdo, $products, $logger)
{
  try {

    // Prepare product insert statement
    $stmt = $pdo->prepare("INSERT INTO Product (id, name, inStock, gallery, description, category, attributes, prices, brand) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($products as $product) {
      // Bind parameters
      $stmt->execute([
        $product["id"],
        $product["name"],
        $product["inStock"] ? 1 : 0,
        json_encode($product["gallery"]),
        $product["description"],
        $product["category"],
        json_encode($product["attributes"]),
        json_encode($product["prices"]),
        $product["brand"]
      ]);
    }

    $logger->info(count($products) . " products inserted");
  } catch (\Exception $e) {
    $logger->error("Product insertion failed: " . $e->getMessage());
    throw $e;
  }
}

// Function to populate categories
function populateCategories($pdo, $categories, $logger)
{
  try {
    // Prepare category insert statement
    $stmt = $pdo->prepare("INSERT INTO Category (name) VALUES (?)");

    foreach ($categories as $category) {
      // Bind parameters
      $stmt->execute([$category["name"]]);
    }

    $logger->info(count($categories) . " categories inserted");
  } catch (\Exception $e) {
    $logger->error("Category insertion failed: " . $e->getMessage());
    throw $e;
  }
}
