<?php
  require_once 'db.php';

class Book {
  private $db;

  public function __construct() {
    $this->db = new Database();
  }

  public function getAllBooks() {
    $query = $this->db->selectAllBooksQuery();

    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function insertBook($title, $author, $description, $count, $link, $type = "book") {
    //validate....
    $query = $this->db->insertBookQuery([
      "title" => $title, 
      "author" => $author,
      "description" => $description,
      "count" => $count,
      "link" => $link,
      "type" =>  $type
    ]);

    return $query;
  }
}
?>
