<?php
  require_once 'db.php';

class Referat {
  private $db;
  private $type;

  public function __construct() {
    $this->db = new Database();
    $this->type = "referat";
  }

  public function getAllReferats() {
    $query = $this->db->selectAllReferatsQuery(["type" => $this->type]);

    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function getSpecificReferat($title) {

    $query = $this->db->selectSpecificReadingQuery(["title" => $title, "type" => $this->type]);

    if ($query["success"]) {
      return ["success" => true, "data" => $query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
      return $query;
    }
  }

  public function addReferat($title, $author, $description, $count, $link, $type = "referat") {
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