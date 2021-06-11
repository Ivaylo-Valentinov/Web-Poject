<?php
  require_once "referat.php";

  header("Content-Type: application/json");

  $errors = [];
  $response = [];
  $referat = new Referat();

  if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $allReferats = $referat->getAllReferats();

    if ($allReferats["success"]) {
      $response = $allReferats["data"];
    } else {
      $errors[] = $allReferats["error"];
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