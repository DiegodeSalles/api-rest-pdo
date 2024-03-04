<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

class ConnectionDao
{
  public static function getConnection()
  {
    try {
      $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'];
      $conn = new PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASS']);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      return $conn;
    } catch (PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
      return null;
    }
  }

  public static function closeConnection($conn)
  {
    if (isset($conn)) {
      $conn = null;
    }
  }
}
