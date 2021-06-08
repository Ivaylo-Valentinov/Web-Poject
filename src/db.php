<?php
class Database {
  private $connection;

  private $insertBook;
  private $selectAllBooks;

  public function __construct() {
    $config = parse_ini_file('../config/config.ini', true);

    $type = $config['db']['type'];
    $host = $config['db']['host'];
    $name = $config['db']['name'];
    $user = $config['db']['user'];
    $password = $config['db']['password'];

    $this->init($type, $host, $name, $user, $password);
  }

  private function init($type, $host, $name, $user, $password) {
    try {
      $this->connection = new PDO("$type:host=$host;dbname=$name", $user, $password,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      $this->prepareStatements();
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  private function prepareStatements() {
    $sql = "INSERT INTO books(title, author, description, count, type, link) VALUES(:title, :author, :description, :count, :type, :link)";
    $this->insertBook = $this->connection->prepare($sql);

    $sql = "SELECT * FROM books";
    $this->selectAllBooks = $this->connection->prepare($sql);
  }

  public function insertBookQuery($data) {
    try {
      $this->insertBook->execute($data);

      return ["success" => true];
    } catch(PDOException $e) {
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function selectAllBooksQuery() {
    try {
      $this->selectAllBooks->execute();

      return ["success" => true, "data" => $this->selectAllBooks];
    } catch(PDOException $e) { 
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
  
  /**
  * Close the connection to the DB
  */
  function __destruct() {
    $this->connection = null;
  }
}
?>