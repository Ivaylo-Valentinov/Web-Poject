<?php

require_once "db.php";
require_once "book.php";
require_once "user.php";

$errors = [];
$response = [];

if(isset($_POST)){
    $data = json_decode($_POST['data'], true);

    $db = new Database();

    $query = $db->getTakenBooks(['user_id' => $data['user_id']]);

    if ($query["success"]) {
        $takenBooks = $query['data']->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $response = ['success' => true, 'data'=> $takenBooks];
        } else {
            $response = ['success' => false, 'data'=> $takenBooks];
        }
    } else {
        $response = ['success' => false, 'data'=> $query];
    }
}

echo json_encode($response);

?>