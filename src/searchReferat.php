<?php
  require_once "referat.php";

 // header("Content-Type: application/json");

  $errors = [];
  $response = [];
  $referat = new Referat();

  if ($_SERVER["REQUEST_METHOD"] === "GET") {
    /*$data = json_decode($_GET["data"], true);

    //$search = isset($data['searchInfo']) ? testInput($data['searchInfo']) : null;
    $search = 
    $result = $referat->getSpecificReferat($search);
    
    if ($result["success"]) {
      $response = $result["data"];
    } else {
      $errors[] = $result["error"];
    }*/

  } else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    echo "enter";
    $data = json_decode($_POST["data"], true);

    $search = isset($data['searchInfo']) ? testInput($data['searchInfo']) : null;
    $result = $referat->getSpecificReferat($search);
    
    if ($result["success"]) {
      $response = $result["data"];
    } else {
      $errors[] = $result["error"];
    }
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