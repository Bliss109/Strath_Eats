<?php
require_once 'connection.php';

class user{
    private $conn;
    private $table = 'users';

    public function __construct(){
        $db =new Database();
        $this->conn = $db->getConnection();
    }

    public function register ($name, $email, $Password){
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO " . $this->table . "(name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindparam(':email', $email);
        $stmt->bindParam(':password', $password);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    
}