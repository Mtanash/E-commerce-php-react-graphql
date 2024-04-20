<?php

namespace errors;

use GraphQL\Error\ClientAware;

class NotFound extends \Exception implements ClientAware
{
  public function isClientSafe(): bool
  {
    return true;
  }
}
