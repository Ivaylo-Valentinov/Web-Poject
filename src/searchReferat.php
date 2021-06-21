<?php
  require_once "referat.php";
  require_once "librarian.php";
  require_once "requestUtility.php";
  require_once "tolkenutility.php";

  $errors = [];
  $response = [];
  $referat = new Referat();
  $librarian = new Librarian();

 if (isset($_POST)) {

  if ($_COOKIE['token']) {
    $tokenUtility = new TokenUtility();
    $isValid = $tokenUtility->checkToken($_COOKIE['token']);

    if ($isValid["success"]) {
     
      $data = json_decode($_POST["data"], true);

      $search = isset($data['searchInfo']) ? RequestUtility::testInput($data['searchInfo']) : null;
      $result = $referat->getSpecificReferat($search);
      
      if ($result["success"]) {
        $response = $librarian( $_SESSION['user_id'], $result["data"]);
      } else {
        $errors[] = $result["error"];
      }

    } 
    else {
        $errors[] = "Not valid cookie";
    }
} else {
    $errors[] = "noCookie";
}


  } else  {
    $errors[] = "Not valid method";
  }

  RequestUtility::sendResponse($response, $errors);

?>