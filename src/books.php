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

    $title = $_POST["title"];
    $author = $_POST["author"];
    $desc = $_POST["desc"];
    $count = $_POST["count"];
    $type = $_POST["type"];

    $file_name = $_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];      
    $file_size = $_FILES['file']['size'];
    $file_tmp_name  = $_FILES['file']['tmp_name'];

    if($file_name){
        move_uploaded_file($file_tmp_name,"../pdfs/".$file_name);
    }
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
