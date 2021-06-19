<?php
    session_start();

    if (isset($_SESSION)) {
        session_unset();
        session_destroy();

        setcookie('token', '', time() - 60 * 30, '/');

        http_response_code(200);
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false]);
    }
?>
