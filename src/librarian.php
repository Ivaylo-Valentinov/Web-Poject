<?php
    require_once "db.php";

    class Librarian {
                private $db;

        public function __construct() {
        
            $this->db = new Database();
        }

       
        public function checkoutBook() {
           
        }

        public function returnBook() {
           
        }

        public function isTaken ($user_id, $book_id) {

        }

       
    }
?>