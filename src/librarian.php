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

        public function isTaken($user_id, $book_id) {
            $query = $this->db->getTakenBooks(["cuid" => $user_id]);
            if (!$query["success"]) {
                return false;
            }

            $books = $query["data"]->fetchAll(PDO::FETCH_ASSOC);

            return in_array($book_id, array_map('getBookId', $books));
        }
    }
    
    function getBookId($book) {
        return $book["id"];
    }
?>