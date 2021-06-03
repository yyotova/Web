<?php
class DB {
  private $connection;

  public function __construct() {
    $db_host = 'localhost';
    $db_name = 'online_shops';
    $username = 'root';
    $password = '';

    $this->connection = new PDO("mysql:host=$db_host;dbname=$db_name", $username, $password, 
      [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
  }

  public function getConnection() {
    return $this->connection;
  }
}
