<?php

namespace classes;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class LoggerFactory
{
  private static $logger;

  public static function getLogger()
  {
    if (self::$logger === null) {
      self::$logger = new Logger("scandiweb-fullstack");
      $handler = new StreamHandler("php://stdout", Level::Debug);
      self::$logger->pushHandler($handler);
    }

    return self::$logger;
  }
}
