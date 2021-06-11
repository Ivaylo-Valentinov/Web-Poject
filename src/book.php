<?php
  require_once 'db.php';

class Book {
  private $db;
  private $type;

  public function __construct() {
    $this->db = new Database();
    $this->type = "book";
  }

  public function getAllBooks() {
    $query = $this->db->selectAllBooksQuery(["type" => $this->type]);

    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function addMark($title, $author, $description, $count, $link, $type = "book") {
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
