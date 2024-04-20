<?php

namespace models;

abstract class AbstractAttributeSet
{
  abstract function getId(): string;
  abstract function getName(): string;
  abstract function getType(): string;
  abstract function getItems(): array;
}
