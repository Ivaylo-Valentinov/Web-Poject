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

        public function bookInStock ($book_id) {
            $query = $this->db->selectBookByIdQuery(["id"=>$book_id]);
            
            if($query["success"]){
                $result = $query["data"]->fetch(PDO::FETCH_ASSOC);
                $checkout_amount = $result["checkout_amount"];
                $count = $result["count"];
                if($checkout_amount < $count){
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

        public function appendIsTakenBook($userId, $content) {
            for($i = 0; $i <count($content); $i++) {
                $content[$i]['isTaken'] = $this->isTakenBool($userId,$content[$i]['id']); 
            }

            return $content;

        }
    }
    
    function getBookId($book) {
        return $book["id"];
    }
?>