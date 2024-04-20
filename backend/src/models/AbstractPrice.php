<?php

namespace models;

abstract class AbstractPrice
{
  abstract function getAmount(): float;
  abstract function getCurrency(): object;
}
