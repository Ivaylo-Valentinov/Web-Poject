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

    // $id = isset($_POST["id"]) ? transformInput($_POST["id"]) : 0;
    // $name = isset($_POST["name"]) ? transformInput($_POST["name"]) : "";
    // $quantity = isset($_POST["quantity"]) ? transformInput($_POST["quantity"]) : 0;
    // $action = isset($_POST["action"]) ? transformInput($_POST["action"]) : "";

    // $result = ["success" => true];

    // if ($action === "add") {
    //   $result = $product->addProduct($id, $quantity);
    // } else if ($action === "buy") {
    //   $result = $product->buyProduct($id, $quantity);
    // } else if ($action === "create") {
    //   $result = $product->createNewProduct($name, $quantity);
    // } else {
    //   $errors[] = "Невалидна операция.";
    // }

    // if (!$result["success"]) {
    //   $errors[] = $result["error"];
    // }

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