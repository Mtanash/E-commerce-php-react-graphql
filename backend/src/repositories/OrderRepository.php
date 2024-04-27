<?php

namespace repositories;

use Psr\Log\LoggerInterface;
use repositories\OrderRepositoryInterface;
use models\Order;

class OrderRepository implements OrderRepositoryInterface
{

  protected $pdo;
  protected $logger;

  public function __construct($pdo, LoggerInterface $logger)
  {
    $this->pdo = $pdo;
    $this->logger = $logger;
  }

  public function create(Order $order): Order
  {
    try {
      $logger = $this->logger;
      $pdo = $this->pdo;

      $logger->debug('OrderRepository->create' . json_encode($order));

      $stmt = $pdo->prepare('INSERT INTO `Order` (products, total, currency, createdAt, updatedAt) VALUES (?, ?, ?, ?, ?)');

      $stmt->execute([json_encode($order->getProducts()), $order->getTotal(), json_encode($order->getCurrency()), $order->getCreatedAt(), $order->getUpdatedAt()]);

      $createdOrderId = $pdo->lastInsertId();

      $order->setId($createdOrderId);

      return $order;
    } catch (\Exception $e) {
      $this->logger->error('ProductRepository->create', ['error' => $e->getMessage()]);
      throw $e;
    }
  }
}
