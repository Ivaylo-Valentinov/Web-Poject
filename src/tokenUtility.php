<?php
  require_once "db.php";

  class TokenUtility {
      private $db;

      public function __construct() {
          $this->db = new Database();
      }

      public function createToken($token, $userId, $expires) {
        $query = $this->db->insertTokenQuery(array("token" => $token, "user_id" => $userId, "expiration_date" => $expires));
        return $query;
      }

      public function checkToken($token) {
        $query = $this->db->selectTokenQuery(array("token" => $token));

        if($query["success"]) {
            $userToken = $query["data"]->fetch(PDO::FETCH_ASSOC);
            if($userToken) {
                if($userToken["expiration_date"] <   time()) {
                    $query = $this->db->selectUserByIdQuery(["id" => $userToken["user_id"]]);

                    if($query["success"]) {
                        $_SESSION["user_id"] = $userToken["user_id"];

                        return array("success" => true, "user" => $userToken["user_id"]);
                    } else {
                        return array("success" => false, "error" => $query["error"], "data"=>"Query Err");
                    }
                } else {
                    return array("success" => false, "error" => "Token expired");
                }
            } else {
                return array("success" => false, "error" => "User token not found");
            }
        } else {
            return array("success" => false, "error" => $query["error"], "data"=>"Query Err 2");
        }
    }
  }
?>