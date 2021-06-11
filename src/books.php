<?php
  require_once "book.php";
  require_once "requestUtility.php";

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

    $title = isset($_POST["title"]) ? RequestUtility::testInput($_POST["title"]) : "";
    $author = isset($_POST["author"]) ? RequestUtility::testInput($_POST["author"]) : "";
    $desc = isset($_POST["desc"]) ? RequestUtility::testInput($_POST["desc"]) : "";
    $count = isset($_POST["count"]) ? RequestUtility::testInput($_POST["count"]) : 0;
    $type = isset($_POST["type"]) ? RequestUtility::testInput($_POST["type"]) : "";

    $file_name = uniqid().$_FILES['file']['name'];
    $file_type = $_FILES['file']['type'];      
    $file_size = $_FILES['file']['size'];
    $file_tmp_name  = $_FILES['file']['tmp_name'];

    $link = "pdfs/".$file_name;

    if($file_name){
        if(!move_uploaded_file($file_tmp_name,"../pdfs/".$file_name)) {
            $errors[] = "Unsuccessful upload";
        }
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
