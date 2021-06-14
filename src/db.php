<?php
class Database {
  private $connection;

  private $insertBook;
  private $selectAllBooks;
  private $selectUser;
  private $selectBookById;
  private $insertToken;
  private $selectToken;
  private $selectUserById;
  private $getTakenBooks;
  private $checkoutBook;
  private $returnBook;
  private $incrementCheckoutCount;
  private $checkTakenStatus;

  public function __construct() {
    $config = parse_ini_file('../config/config.ini', true);

    $type = $config['db']['type'];
    $host = $config['db']['host'];
    $name = $config['db']['name'];
    $user = $config['db']['user'];
    $password = $config['db']['password'];

    $this->init($type, $host, $name, $user, $password);
  }

  private function init($type, $host, $name, $user, $password) {
    try {
      $this->connection = new PDO("$type:host=$host;dbname=$name", $user, $password,
      array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

      $this->prepareStatements();
    } catch(PDOException $e) {
      echo "Connection failed: " . $e->getMessage();
    }
  }

  private function prepareStatements() {
    $sql = "INSERT INTO books(title, author, description, count, type, link) VALUES(:title, :author, :description, :count, :type, :link)";
    $this->insertBook = $this->connection->prepare($sql);

    $sql = "SELECT * FROM books WHERE type = :type";
    $this->selectAllBooks = $this->connection->prepare($sql);

    $sql = "SELECT * FROM users WHERE username = :username";
    $this->selectUser = $this->connection->prepare($sql);

    $sql = "SELECT * FROM books WHERE id = :id";
    $this->selectBookById = $this->connection->prepare($sql);

    $sql = "INSERT INTO tokens(user_id, token,  expiration_date) VALUES (:user_id, :token,  :expiration_date)";
    $this->insertToken = $this->connection->prepare($sql);

    $sql = "SELECT * FROM tokens WHERE token=:token";
    $this->selectToken = $this->connection->prepare($sql);

    $sql = "SELECT * FROM users WHERE id=:id";
    $this->selectUserById = $this->connection->prepare($sql);

    $sql = "INSERT INTO users(username, password, email) VALUES (:username, :password, :email)";
    $this->insertUser = $this->connection->prepare($sql);
    
    $sql = "SELECT * FROM taken_books tb JOIN books b ON tb.book_id = b.id WHERE user_id=:cuid ";
    $this->getTakenBooks = $this->connection->prepare($sql);

    $sql = "UPDATE books SET checkout_amount = checkout_amount+1 WHERE id =:bookId";
    $this->incrementCheckoutCount = $this->connection->prepare($sql);
    
    $sql = "INSERT INTO taken_books(user_id, book_id, expiration_date) VALUES (:user_id, :bookid, :expDate)";
    $this->checkoutBook = $this->connection->prepare($sql);

    $sql = "DELETE FROM `taken_books` WHERE book_id=:bookid";
    $this->returnBook = $this->connection->prepare($sql);

    $sql = "SELECT * FROM books WHERE type = :type";
    $this->selectAllReferats = $this->connection->prepare($sql);

    $sql = "SELECT * FROM books WHERE title LIKE CONCAT('%', :title, '%') AND type = :type";
    $this->selectSpecificReading = $this->connection->prepare($sql);

    $sql = "SELECT * FROM `taken_books` WHERE book_id=:bookid && user_id =:userid";
    $this->checkTakenStatus = $this->connection->prepare($sql);

  }

  public function insertBookQuery($data) {
    try {
      $this->insertBook->execute($data);

      return ["success" => true];
    } catch(PDOException $e) {
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function selectAllBooksQuery($data) {
    try {
      $this->selectAllBooks->execute($data);

      return ["success" => true, "data" => $this->selectAllBooks];
    } catch(PDOException $e) { 
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  public function selectUserQuery($data) {
    try {
        $this->selectUser->execute($data);

        return ["success" => true, "data" => $this->selectUser];
    } catch(PDOException $e) {
        return ["success" => false, "error" => $e->getMessage()];
    }
  }

  public function insertUserQuery($data) {
    try {
        $this->insertUser->execute($data);

        return ["success" => true];
    } catch(PDOException $e) {
        $this->connection->rollBack();
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
  
  public function selectUserByEmailQuery($email) {
    try {
        $this->selectUser->execute($email);

        return ["success" => true, "data" => $this->selectUser];
    } catch(PDOException $e) {
        return ["success" => false, "error" => $e->getMessage()];
    }
  }

  public function selectAllReferatsQuery($data) {
    try{
      $this->selectAllReferats->execute($data);

      return ["success" => true, "data" => $this->selectAllReferats];
    }catch(PDOException $e) {
      return ["success" => false, "error" => $e->getMessage()];
    }
  }

  public function selectSpecificReadingQuery($data) {
    try{
      $this->selectSpecificReading->execute($data);

      return ["success" => true, "data" => $this->selectSpecificReading];
    }catch(PDOException $e) {
      return ["success" => false, "error" => $e->getMessage()];
    }
  }
  
   /**
         * We use this method to execute queries for inserting user session token
         * We only execute the created prepared statement for inserting user in DB with new database
         */
      public function insertTokenQuery($data) {
        try{
            $this->insertToken->execute($data);
            return array("success" => true);
          } catch(PDOException $e){
            return ["success" => false, "error" => $e->getMessage()];
          }
      }

      /**
       * We use this method to execute queries for getting user session token
       * We only execute the created prepared statement for selecting user in DB with new database
       * If the query was executed successfully, we return the result of the executed query
       */
      public function selectTokenQuery($data) {
          try{
              $this->selectToken->execute($data);

              return array("success" => true, "data" => $this->selectToken);
          } catch(PDOException $e){

              return ["success" => false, "error" => $e->getMessage()];
          }
      }

      /**
         * We use this method to execute queries for getting user data by user id
         * We only execute the created prepared statement for selecting user in DB with new database
         * If the query was executed successfully, we return the result of the executed query
         */
        public function selectUserByIdQuery($data) {
          try{
              $this->selectUserById->execute($data);

              return array("success" => true, "data" => $this->selectUserById);
          } catch(PDOException $e){

              return ["success" => false, "error" => $e->getMessage()];
          }
      }

      public function selectBookByIdQuery($data) {
        try{
            $this->selectBookById->execute($data);

            return array("success" => true, "data" => $this->selectBookById);
        } catch(PDOException $e){

            return ["success" => false, "error" => $e->getMessage()];
        }
    }

      public function getTakenBooks($data) {
        try {
            $this->getTakenBooks->execute($data);

            return ["success" => true, "data" => $this->getTakenBooks];
          } catch(PDOException $e) {
            return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        }
    }

    public function checkoutBook($data) {
      try {
          $this->connection->beginTransaction();

          $this->checkoutBook->execute($data);
          $this->incrementCheckoutCount->execute(["bookId" => $data["bookid"]]);

          $this->connection->commit();

          return ["success" => true, "data" => $this->checkoutBook];
        } catch(PDOException $e) {
            $this->connection->rollBack();
            return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
        }
  }

  public function isBookTaken($data) {
    try {
        $this->checkTakenStatus->execute($data);

        return ["success" => true, "data" => $this->checkTakenStatus];
      } catch(PDOException $e) {
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
}

  public function returnBook($data) {
    try {
        $this->returnBook->execute($data);

        return ["success" => true, "data" => $this->returnBook];
      } catch(PDOException $e) {
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
}

      /**
  * Close the connection to the DB
  */
  function __destruct() {
    $this->connection = null;
  }

}
?>
