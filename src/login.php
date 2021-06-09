<?php
    require_once 'user.php';
    require_once 'tokenUtility.php';


    session_start();

    header('Content-Type: application/json');

    $errors = [];
    $response = [];

    if (isset($_POST)) {
        $data = json_decode($_POST['data'], true);

        // TODO: testInput

        if(!$data['userName']) {
            $errors[] = 'Please eneter user name';
        }

        if(!$data['password']) {
            $errors[] = 'Please enter password';
        }

        if($data['username'] && $data['password']) {
            $user = new User($data['username'], $data['password']);
            $isValid = $user->isValid();

            if($isValid['success']) {
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['userId'] = $user->getUserId();

                $tokenUtility = new TokenUtility();
                $token = bin2hex(random_bytes(8));
                $expires = time() + 30 * 24 * 60 * 60;
                setcookie('token', $token, $expires, '/');
                $tokenUtility->createToken($token, $_SESSION['userId'], $expires);


                // if ($data['remember']) {
                //     // Create cookie for remembering the user
                //     $tokenUtility = new TokenUtility();
                //     $token = bin2hex(random_bytes(8));
                //     $epxires = time() + 30 * 24 * 60 * 60;
                //     setcookie('token', $token, $expires, '/');
                //     $tokenUtility->createToken($token, $_SESSION['userId'], $expires);
                // }
            } else {
                $errors[] = $isValid['error'];
            }
        }
    } else {
        $errors[] = 'Invalid request';

    }

    if($errors) {
        $response = ['success' => false, 'data' => $errors];
        http_response_code(404);
    } else {
        $response = ['success' => true];
    }

    echo json_encode($response);
?>