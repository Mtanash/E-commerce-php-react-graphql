<?php

namespace classes;

use GraphQL\Server\ServerConfig;
use GraphQL\Server\StandardServer;
use classes\LoggerFactory;
use DI\Container;
use database\Database;
use repositories\CategoryRepository;
use repositories\ProductRepository;
use repositories\OrderRepository;

class GraphqlServer
{
  public static function get(): StandardServer
  {
    $logger = LoggerFactory::getLogger();
    $schema = require __DIR__ . '/../schema/schema.php';

    $config = ServerConfig::create()->setSchema($schema)->setDebugFlag(true)->setQueryBatching(true)->setContext(self::getContext());

    return new StandardServer($config);
  }

  private static function getContext()
  {
    $config = require __DIR__ . '/../config.php';
    $logger = LoggerFactory::getLogger();
    $pdo = Database::getConnection($config, $logger);

    $graphContainer = new Container([
      'logger' => $logger,
      'pdo' => $pdo,
      'repository' => new Container([
        'product' => new ProductRepository($pdo, $logger),
        'category' => new CategoryRepository($pdo, $logger),
        'order' => new OrderRepository($pdo, $logger),
      ])
    ]);

    return $graphContainer;
  }
}
