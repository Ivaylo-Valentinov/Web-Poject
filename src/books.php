<?php
  require_once "book.php";
  require_once "librarian.php";
  require_once "requestUtility.php";
  require_once "tokenutility.php";

  $errors = [];
  $response = [];
  $book = new Book();
  $librarian = new Librarian();


  if ($_SERVER["REQUEST_METHOD"] === "GET") {

    
    if ($_COOKIE['token']) {
      $tokenUtility = new TokenUtility();
      $isValid = $tokenUtility->checkToken($_COOKIE['token']);

      if ($isValid["success"]) {
        $allBooks = $book->getAllBooks();

        if ($allBooks["success"]) {
          $response = $librarian->appendIsTakenBook( $_SESSION['user_id'], $allBooks["data"]);
        } else {
          $errors[] = $allBooks["error"];
        }
      } 
      else {
          $errors[] = "Not valid cookie";
      }
  } else {
      $errors[] = "noCookie";
  }

  } else if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $title = isset($_POST["title"]) ? RequestUtility::testInput($_POST["title"]) : "";
    $author = isset($_POST["author"]) ? RequestUtility::testInput($_POST["author"]) : "";
    $desc = isset($_POST["desc"]) ? RequestUtility::testInput($_POST["desc"]) : "";
    $count = isset($_POST["count"]) ? RequestUtility::testInput($_POST["count"]) : 0;
    $type = isset($_POST["type"]) ? RequestUtility::testInput($_POST["type"]) : "";

    $file_name = uniqid().$_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];
    $file_tmp_name  = $_FILES['file']['tmp_name'];

    $link = "pdfs/".$file_name;

    $uploadResult = $book->saveBookPDF($file_tmp_name, $file_name, $file_type);

    if (!$uploadResult["success"]) {
        $errors[] = $uploadResult["error"];
    }

    if (!$errors) {
        $result = $book->insertBook($title, $author, $desc, $count, $link);

        if(!$result["success"]) {
            unlink("../pdfs/".$file_name);
            $errors[] = $result["error"];
        }
    }
  } else  {
    $errors[] = "Not valid method";
  }

  RequestUtility::sendResponse($response, $errors);
?>
