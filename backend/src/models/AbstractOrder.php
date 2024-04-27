<?php

namespace models;


abstract class AbstractOrder
{
  abstract function getId(): string;
  abstract function setId(string $id): void;
  abstract function getOrderNumber(): string;
  abstract function getProducts(): array;
  abstract function getTotal(): float;
  abstract function getCurrency(): array;
  abstract function getCreatedAt(): string;
  abstract function getUpdatedAt(): string;
}
