<?php
  require_once "book.php";
  require_once "requestUtility.php";

 // header("Content-Type: application/json");

  $errors = [];
  $response = [];
  $book = new Book();

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
   //TO DO

  } else if (isset($_POST)) {
    $data = json_decode($_POST["data"], true);

    $search = isset($data['searchInfo']) ? RequestUtility::testInput($data['searchInfo']) : null;
    $result = $book->getSpecificBook($search);
    
    if ($result["success"]) {
      $response = $result["data"];
    } else {
      $errors[] = $result["error"];
    }
    //TO DO
  } else  {
    $errors[] = "Невалидна заявка.";
  }

  RequestUtility::sendResponse($response, $errors);

?>