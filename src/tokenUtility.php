<?php
  require_once "db.php";

  /**
   * Use this class to manage user session tokens
   */
  class TokenUtility {
      private $db;

      public function __construct() {
          $this->db = new Database();
      }

      /**
       * Create user session token
       */
      public function createToken($token, $userId, $expires) {
        $query = $this->db->insertTokenQuery(array("token" => $token, "user_id" => $userId, "expiration_date" => $expires));
        //return $query;
      }

      /**
       * Check whether the token is valid
       */
      public function checkToken($token) {
        $query = $this->db->selectTokenQuery(array("token" => $token));

        /**
         * If the query was executed successfully we can check whether the token is valid and
         * to return the user's  data
         */
        if($query["success"]) {
            /**
             * $query["data"] holds a PDO object with the result of the executed query.
             * We can get the data from the returned result as associative array, calling
             * the fetch(PDO::FETCH_ASSOC) method on $query["data"].
             */
            $userToken = $query["data"]->fetch(PDO::FETCH_ASSOC);

            /**
             * If there wasn't found a token variable $userToken will be null
             */
            if($userToken) {
                /**
                 * We check whether the token has expired
                 * If the token is still valid, we get the user's data
                 */
                if($userToken["expiration_date"] <   time()) {
                    $query = $this->db->selectUserByIdQuery(["id" => $userToken["user_id"]]);

                    /**
                     * If the query was executed successfully we can return user's data
                     */
                    if($query["success"]) {
                        /**
                         * $query["data"] holds a PDO object with the result of the executed query.
                         * We can get the data from the returned result as associative array, calling
                         * the fetch(PDO::FETCH_ASSOC) method on $query["data"].
                         */
                        $foundUser = $query["data"]->fetch(PDO::FETCH_ASSOC);
                        $_SESSION["user_id"] = $userToken["user_id"];
                        $user = new User($foundUser["username"],  $foundUser["password"]);
                        $user->setEmail($foundUser["email"]);

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