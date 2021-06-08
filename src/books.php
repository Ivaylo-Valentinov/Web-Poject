<?php
  require_once "book.php";

  header("Content-Type: application/json");

  $errors = [];
  $response = [];
  $book = new Book();

  if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $allBooks = $book->getAllBooks();

    if ($allBooks["success"]) {
      $response = $allBooks["data"];
    } else {
      $errors[] = $allBooks["error"];
    }

  } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    //TO DO
  } else  {
    $errors[] = "Невалидна заявка.";
  }

  if ($errors) {
    http_response_code(400);

    echo json_encode($errors);
  } else {
    http_response_code(200);

    echo json_encode($response);
  }

  function transformInput($input) {
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    
    return $input;
  }
?>