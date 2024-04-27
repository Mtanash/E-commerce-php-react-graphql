<?php

namespace models;


use classes\LoggerFactory;
use models\AbstractOrder;

class Order extends AbstractOrder
{
  /**
   * @var int
   */
  protected $id;
  /**
   * @var array
   */
  protected $products;
  /**
   * @var float
   */
  protected $total;
  /**
   * @var array
   */
  protected $currency;
  /**
   * @var string
   */
  protected $createdAt;
  /**
   * @var string
   */
  protected $updatedAt;

  public function __construct(
    $products,
    $total,
    $currency,
  ) {
    $this->products = $products;
    $this->total = $total;
    $this->currency = $currency;
    $this->createdAt = date('Y-m-d H:i:s');
    $this->updatedAt = date('Y-m-d H:i:s');
  }

  public function getId(): string
  {
    return $this->id;
  }

  public function setId(string $id): void
  {
    $this->id = $id;
  }

  public function getOrderNumber(): string
  {
    return $this->id;
  }

  public function getProducts(): array
  {
    return $this->products;
  }

  public function getTotal(): float
  {
    return $this->total;
  }

  public function getCurrency(): array
  {
    return $this->currency;
  }

  public function getCreatedAt(): string
  {
    return $this->createdAt;
  }

  public function getUpdatedAt(): string
  {
    return $this->updatedAt;
  }
}
