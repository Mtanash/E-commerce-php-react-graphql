<?php

namespace repositories;

use models\Order;

interface OrderRepositoryInterface
{
  /**
   * Creates a new order in the database.
   * 
   * @param $order The order object or array to create.
   * @throws \Exception If an error occurs while creating the product.
   * @return Order The order created.
   */
  public function create(Order $order): Order;
}
