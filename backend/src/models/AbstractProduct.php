<?php

namespace models;

use models\Category;

abstract class AbstractProduct
{
  abstract function getId(): string;
  abstract function getName(): string;
  abstract function isInStock(): bool;
  abstract function getGallery(): array;
  abstract function getDescription(): string;
  abstract function getCategory(): Category;
  abstract function getAttributes(): array;
  abstract function getPrices(): array;
  abstract function getBrand(): string;
}
