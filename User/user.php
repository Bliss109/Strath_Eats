<?php
require_once '../dbConn/Connection.php';

class User {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function register ($name, $email, $Password){
        $hashedPassword = password_hash($Password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->db->prepare($sql);

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
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->db->prepare($sql);
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
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data) {
        $allowedFields = ['email', 'phone_number', 'student_id'];
        $updates = [];
        $values = [];

        foreach ($allowedFields as $field) {
            if (isset($data[$field])) {
                $updates[] = "$field = ?";
                $values[] = $data[$field];
            }
        }

        if (empty($updates)) {
            return false;
        }

        $values[] = $userId;
        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE user_id = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($values);
    }

    public function updateProfilePicture($userId, $fileName) {
        $stmt = $this->db->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
        return $stmt->execute([$fileName, $userId]);
    }

    public function verifyPassword($userId, $currentPassword) {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($currentPassword, $user['password'])) {
            return true;
        }
        return false;
    }

    public function updatePassword($userId, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE user_id = ?");
        return $stmt->execute([$hashedPassword, $userId]);
    }
}
