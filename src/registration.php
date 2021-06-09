<?php
    require_once "user.php";

    header('Content-Type: application/json');
    
    $errors = [];
    $response = [];

    if ($_POST) {
        $data = json_decode($_POST['data'], true);

       // $username = $data['username'];
        //$password = $data['password'];
        //$confirmPassword = $data['confirmPassword'];
        //$email = $data['email'];

      if (!$data['username']) {
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
      }

      if ($data['username'] && $data['password'] && $data['confirmPassword'] && $data['email']) {
        if ($data['password'] != $data['confirmPassword']) {
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


    if ($errors) {
      $response = ["success" => false, "data" => $errors];
    } else {
      $response = ["success" => true];
    }


    echo json_encode($response);
?>