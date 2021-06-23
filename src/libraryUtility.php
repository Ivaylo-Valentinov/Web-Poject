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
                $canTakeAnotherBook = $lib->canTakeBook($_SESSION['user_id']);
                $bookInStock = $lib->bookInStock( $data["bookid"]);
                if(!$isTaken ) {
                    if($canTakeAnotherBook){
                        if($bookInStock){
                            $query = $db->checkoutBook(["user_id" => $_SESSION['user_id'], "bookid" => $data["bookid"], "expDate" => date('Y-m-d', strtotime("+20 days"))]);
                        }else{
                            $query = ["success"=>false, "error"=>"Book not in stock!"];
                        }
                        
                    }
                    else{
                        $query = ["success"=>false, "error"=>"Can't take more books!"];
                    }
                    
                }
                else{
                    $query = ["success"=>false, "error"=>"Book already taken!"];
                }
            }
            else{
                $query = $db->returnBook(["user_id" => $_SESSION['user_id'], "bookid" => $data["bookid"]]);
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