<?php

namespace models;

abstract class AbstractAttribute
{
  abstract function getId(): string;
  abstract function getValue(): string;
  abstract function getDisplayValue(): string;
}
