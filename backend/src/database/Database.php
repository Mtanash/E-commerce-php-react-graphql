<?php

namespace database;

use PDO;
use PDOException;
use Monolog;

class Database
{
  private static $pdo;

  public static function getConnection(array $config, ?Monolog\Logger $logger)
  {
    if (self::$pdo === null) {
      try {
        $dbname = $config['db']['dbname'];
        $host = $config['db']['host'];
        $user = $config['db']['user'];
        $pass = $config['db']['pass'];

        $pdo = new PDO($host, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // create the db if it does not exist
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $dbname");

        $pdo->exec("USE $dbname");

        self::$pdo = $pdo;
        if ($logger !== null) {
          $logger->info("DB connected");
        }
      } catch (PDOException $e) {
        if ($logger !== null) {
          $logger->error($e->getMessage());
        }
        $pdo = null;
      }
    }

    return self::$pdo;
  }
}
