<?php
    require_once "user.php";
    
    $errors = [];
    $response = [];

    if (isset($_POST)) {
        $data = json_decode($_POST["data"], true);

        $username = isset($data['username']) ? testInput($data['username']) : null;
        $password = isset($data['password']) ? testInput($data['password']) : null;
        $confirmPassword = isset($data['confirmPassword']) ? testInput($data['confirmPassword']) : null;
        $email = isset($data['email']) ? testInput($data['email']) : null;

      if (!$username) {
        $errors[] = "Username is required.";
      }

      if (!$password) {
        $errors[] = "Password is required.";
      }

      if (!$confirmPassword) {
        $errors[] = "Password confirmation is required.";
      }

      if (!$email) {
        $errors[] = "Email is required.";
      }

      if ($username && $password && $confirmPassword && $email) {
        if ($password != $confirmPassword && !$errors) {
          $errors[] = "Password confirmation does not match password.";
        } else {
            $user = new User($username, $password);
            $exists = $user->userExists();

            if ($exists) {
              $errors[] = "Username is already taken.";
            } else {
              $passwordHash = password_hash($data['password'], PASSWORD_DEFAULT);
              $user->createUser($passwordHash, $data['email']);
            }
        }
      }
    } else {
      $errors[] = "Invalid request.";
    }

    if ($errors) {
      $response = ["success" => false, "data" => $errors];
    } else {
      $response = ["success" => true];
    }

    function testInput($input) {
        $input = trim($input);
        $input = htmlspecialchars($input);
        $input = stripslashes($input);
        
        return $input;
    }

    echo json_encode($response);
?>