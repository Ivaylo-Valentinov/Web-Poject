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

  public function getSpecificBook($title) {

    $query = $this->db->selectSpecificReadingQuery(["title" => $title, "type" => $this->type]);

    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function getBookById($id) {
    $query = $this->db->selectBookByIdQuery(["id" => $id]);
    
    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetch(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function saveBookPDF($file_tmp_name, $file_name, $file_type) {
    if($file_name && $file_type === 'application/pdf'){
        if(!move_uploaded_file($file_tmp_name,"../pdfs/".$file_name)) {
            return ["success" => false, "error" => "Unsuccessful upload"];
        }
    } else {
        return ["success" => false, "error" =>  "Cannot save file"];
    }

    return ["success" => true];
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
      "type" =>  $this->type
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
