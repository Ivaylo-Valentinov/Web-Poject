<?php

require_once "db.php";
require_once "book.php";
require_once "user.php";
require_once 'tokenUtility.php';
require_once 'librarian.php';

$errors = [];
$response = [];
$query;

if(isset($_POST)){
    $data = json_decode($_POST["data"], true);

    if ($_COOKIE['token']) {
        $tokenUtility = new TokenUtility();
        $isValid = $tokenUtility->checkToken($_COOKIE['token']);
        if ($isValid["success"]) {
            
            $db = new Database();
            $lib = new Librarian();
            $opType = $data["opType"];

            if($opType == "check"){
                $isTaken =$lib->isTaken($_SESSION['user_id'], $data["bookid"]);
                if(!$isTaken){
                    $query = $db->checkoutBook(["user_id" => $_SESSION['user_id'], "bookid"=> $data["bookid"], "expDate"=>'2021-07-06']);

                }
                else{
                        $query = ["success"=>false, "error"=>"Book is taken!"];
                }
                
            }
            else{
                $query = $db->returnBook(["bookid" => $data["bookid"]]);
                print_r($data);
            }

            if ($query["success"]) {
                $response =  ["success" => true, "thing"=>$isValid];
            } else {
                $errors[] = $query["error"];
            }
        } 
        else 
        {
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