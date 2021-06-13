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
            $query = $this->db->isBookTaken(["bookid" => $book_id, "userid"=>$user_id]);

            if($query["success"]){
                $result = $query["data"]->fetch(PDO::FETCH_ASSOC);
                if($result){
                    return true;
                }
                else{
                        return false;
                }
            }
            else{
                    return $query;
            }
        }

       
    }
?>