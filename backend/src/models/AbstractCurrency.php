<?php

namespace models;

abstract class AbstractCurrency
{
  abstract function getLabel(): string;
  abstract function getSymbol(): string;
}
