<?php
    require_once "user.php";

    header('Content-Type: application/json');
    
    $errors = [];
    $response = [];

    if ($_POST) {
        $data = json_decode($_POST['data'], true);

        $username = isset($data['username']);
        $password = isset($data['password']);
        $confirmPassword = isset($data['confirmPassword']);
        $email = isset($data['email']);

      /*if (!$data['username']) {
          echo "user empty";
        $errors[] = "Username is required.";
      }

      if (!$data['password']) {
        $errors[] = "Password is required.";
      }//Not sure if this is the way
      else if(!preg_match("#^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).{6,10}$#",$data['password'])){
        $errors[] = "Password is not valid.";
      }

      if (!$data['confirmPassword']) {
        $errors[] = "Password confirmation is required.";
      }

      if (!$data['email']) {
        $errors[] = "Email is required.";
      } //Not sure if this is the way
      else if(!preg_match("/^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/", $data['email'])) {
        $errors[] = "Email is not valid.";
      }*/

      validateData($data);

      if ($username && $password && $confirmPassword && $email) {
        if ($password != $confirmPassword) {
          $errors[] = "Password confirmation does not match password.";
        } else {
            // TODO: 
            // * Check for user existance
            // * Hash password
            // * Create user in DB
            $user = new User($username, $password);
            $exists = $user->userExists();

            if ($exists) {
              $errors[] = "Username is already taken.";
            } else {
              $passwordHash = password_hash($password, PASSWORD_DEFAULT);
              $user->createUser($passwordHash, $email);
            }
        }
      }
    } else {
      $erros[] = "Invalid request.";
    }

    function validateData($data) {
        if (!$username) {
            $errors[] = 'Please enter username';
        } elseif (mb_strlen($name) > 30) {
            $errors[] = 'Username problem';
        } else {
            $response['username'] = $username;
        }

        if (!$password) {
            $errors[] = 'Please enter username';
        } elseif (mb_strlen($name) > 30) {
            $errors[] = 'Password problem';
        } else {
            $response['password'] = $password;
        }

        if (!$confirmPassword) {
            $errors[] = 'Please confirmed password';
        } elseif ($confirmPassword != $password) {
            $errors[] = 'Confirm password is not the same as the password.';
        } else {
            $response['conformPassword'] = $confirmPassword;
        }

        if (!$email) {
            $errors[] = 'Please enter email';
        } elseif (mb_strlen($name) > 30) {
            $errors[] = 'Too long email';
        } else {
            $response['email'] = $email;
        }

    }

    if ($errors) {
        echo "did you get here";
      $response = ["success" => false, "data" => $errors];
    } else {
        echo "did you get here 2";
      $response = ["success" => true];
    }


    echo json_encode($response);
?>