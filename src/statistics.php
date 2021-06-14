<?php
  require_once "book.php";
  require_once "referat.php";
  require_once "requestUtility.php";

  $errors = [];
  $response = [];
  $book = new Book();
  $referat = new Referat();

  if ($_SERVER["REQUEST_METHOD"] === "GET") {

    $mostReadBooks = $book->getAllBooks();
    $mostReadRefs = $referat->getAllReferats();

    if ($mostReadBooks["success"] && $mostReadRefs["success"]) {
        usort($mostReadRefs["data"], "checkMostReads");
        usort($mostReadBooks["data"], "checkMostReads");
        $response = ["refs" => array_slice($mostReadRefs["data"], 0, 5), "books" => array_slice($mostReadBooks["data"], 0, 5)];
    }

    if (!$mostReadBooks["success"]) {
        $errors[] = $mostReadBooks["error"];
    }

    if (!$mostReadRefs["success"]) {
        $errors[] = $mostReadRefs["error"];
    }
  } else  {
    $errors[] = "Not valid method";
  }

  function checkMostReads($book1, $book2) {
    if ($book1["checkout_amount"] == $book2["checkout_amount"]) {
        return 0;
    }
    return ($book1["checkout_amount"] > $book2["checkout_amount"]) ? -1 : 1;
  }

  RequestUtility::sendResponse($response, $errors);
?>
