<?php
require_once "librarian.php";
require_once "requestUtility.php";
require_once "book.php";
require_once 'tokenUtility.php';

$errors = [];
$response = [];
$librarian = new Librarian();
$book = new Book();

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if ($_COOKIE['token']) {
        $tokenUtility = new TokenUtility();
        $isValid = $tokenUtility->checkToken($_COOKIE['token']);

        if ($isValid["success"]) {
            $bookId = isset($_GET['id']) ? RequestUtility::testInput($_GET['id']) : 0;
            
            if ($librarian->isTaken($_SESSION['user_id'], $bookId)) {
                $request = $book->getBookById($bookId);

                if ($request["success"]) {
                    $response = $request["data"];
                } else {
                    $errors[] = $request["error"];
                }
            } else {
                $errors[] = "Book is not taken";
            }
        } 
        else {
            $errors[] = "Not valid cookie";
        }
    } else {
        $errors[] = "noCookie";
    }
} else {
    $errors[] = "Not valid method";
}

RequestUtility::sendResponse($response, $errors);
?>
