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

  public function insertBook($title, $author, $description, $count, $link) {
    $validate = $this->validateString($title);
    if (!$validate["success"]) {
      return $validate;
    }

    $validate = $this->validateString($author);
    if (!$validate["success"]) {
      return $validate;
    }

    $validate = $this->validateString($description);
    if (!$validate["success"]) {
      return $validate;
    }

    $validate = $this->validatePositiveNumber($count);
    if (!$validate["success"]) {
      return $validate;
    }

    $query = $this->db->insertBookQuery([
      "title" => $title, 
      "author" => $author,
      "description" => $description,
      "count" => $count,
      "link" => $link,
      "type" =>  "book"
    ]);

    return $query;
  }

    private function validateString($string) {
        if (mb_strlen($string) === 0) {
            return ["success" => false, "error" => "String must not be empty"];
        }

        return ["success" => true];
    }

    private function validatePositiveNumber($number) {
        if (!is_numeric($number) || $number < 0) {
            return ["success" => false, "error" => "Must be a positive number"];
        }
    
        return ["success" => true];
    }
}
?>
