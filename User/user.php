<?php
require_once '../dbConn/Connection.php';

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
        $stmt->bindParam(':password', $hashedPassword);
        
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }

    public function login($email, $password){
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

             if(password_verify($password, $user['password'])){
                return $user;
             }
        }

        return false;
    }
    
}
?>
