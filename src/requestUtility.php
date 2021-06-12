<?php
class RequestUtility {
    public static function sendResponse($response, $errors) {
        header("Content-Type: application/json");

        if ($errors) {
            http_response_code(400);

            echo json_encode($errors);
        } else {
            http_response_code(200);

            echo json_encode($response);
        }
    }

    public static function testInput($input) {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
    
        return $input;
    }
}
?>
