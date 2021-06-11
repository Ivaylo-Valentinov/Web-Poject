<?php

require_once "db.php";
require_once "book.php";
require_once "user.php";

$errors = [];
$response = [];

if(isset($_POST)){
    $data = json_decode($_POST["data"], true);

    $db = new Database();

    $query = $db->getTakenBooks(["cuid" => 1]);
    
    if ($query["success"]) {
        $takenBooks = $query["data"]->fetch(PDO::FETCH_ASSOC);
        $response =  ["success" => true, "data" =>$query["data"]->fetchAll(PDO::FETCH_ASSOC)];
    } else {
        $errors[] = $query["error"];
    }

    if ($errors) {
        http_response_code(400);    
    
        echo json_encode($errors);
      }
}

http_response_code(200);
    
echo json_encode($response);
?>