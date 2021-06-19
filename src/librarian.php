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

        public function canTakeBook ($user_id) {
            $query = $this->db->selectUserByIdQuery(["id"=>$user_id]);
            
            if($query["success"]){
                $result = $query["data"]->fetch(PDO::FETCH_ASSOC);
                $checkedBookCount = $result["checked_count"];
                if($checkedBookCount < 3){
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



        public function isTakenBool($user_id, $book_id) {
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