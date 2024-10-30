<?php
require_once '../dbConn/Connection.php';

class User {
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

    public function getUserProfile($userId) {
        $sql = "SELECT id, name, email, phone_number, profile_picture 
                FROM " . $this->table . " 
                WHERE id = :userId";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data) {
        $allowedFields = ['name', 'email', 'phone_number'];
        $updates = [];
        $params = [];

        foreach ($data as $field => $value) {
            if (in_array($field, $allowedFields)) {
                $updates[] = "$field = :$field";
                $params[":$field"] = $value;
            }
        }

        if (empty($updates)) {
            return false;
        }

        $params[':userId'] = $userId;
        
        $sql = "UPDATE " . $this->table . " 
                SET " . implode(', ', $updates) . " 
                WHERE id = :userId";
        
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    public function updateProfilePicture($userId, $imagePath) {
        $sql = "UPDATE " . $this->table . " 
                SET profile_picture = :imagePath 
                WHERE id = :userId";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->bindParam(':userId', $userId);
        
        return $stmt->execute();
    }
}
