<?php

require_once "db.php";
require_once "book.php";
require_once "user.php";
require_once 'tokenUtility.php';

$errors = [];
$response = [];

if(isset($_POST)){
    $data = json_decode($_POST["data"], true);

    if ($_COOKIE['token']) {
        $tokenUtility = new TokenUtility();
        $isValid = $tokenUtility->checkToken($_COOKIE['token']);

        if ($isValid["success"]) {
            
            $db = new Database();

            $query = $db->getTakenBooks(["cuid" => $_SESSION['user_id']]);
            if ($query["success"]) {
                $response =  ["success" => true,"userID"=>$isValid ,"data" =>$query["data"]->fetchAll(PDO::FETCH_ASSOC)];
            } else {
                $errors[] = $query["error"];
            }
        } 
        else{
            $response =  ["success" => "Invalid cookie", "data" =>$isValid];
        }
    } else {
        $response =  ["success" => false, "data" =>"noCookie"];
    }
    
    

    if ($errors) {
        http_response_code(400);    
    
        echo json_encode($errors);
      }
      else{
        http_response_code(200);
        echo json_encode($response);
      }
} 


?>