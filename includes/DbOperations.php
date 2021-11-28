<?php 

    class DbOperations{
        //the database connection variable
        private $con; 
 
        //inside constructor
        //we are getting the connection link
        function __construct(){
            require_once dirname(__FILE__) . '/DbConnect.php';
            $db = new DbConnect; 
            $this->con = $db->connect(); 
        }
 
 
        /*  The Create Operation 
            The function will insert a new user in our database
        */
        public function createUser($email, $password, $name, $school){
            if(!$this->isEmailExist($email)){
                $stmt = $this->con->prepare("INSERT INTO users (email, password, name, school) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $email, $password, $name, $school);
                if($stmt->execute()){
                    return USER_CREATED; 
                }else{
                    return USER_FAILURE;
                }

            }
           
           return USER_EXISTS; 
        }
 
        /*
            The Read Operation
            The function is checking if the user exist in the database or not
        */
        private function isEmailExist($email){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->bind_param("s", $email);
            $stmt->execute(); 
            $stmt->store_result(); 
            return $stmt->num_rows > 0;  
        }
    }