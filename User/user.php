<?php
require_once '../dbConn/Connection.php';


class User
{
    private $conn;
    private $table = 'users';

    public function __construct(){
        $db =new Database();
        $this->conn = $db->getConnection();
    }
    // Register a new user
    public function register($name, $email, $password, $phone_number)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


        $sql = "INSERT INTO users (name, email, password, phone_number) VALUES (:name, :email, :password, :phone_number)";
        $stmt = $this->conn->prepare($sql);

        // Bind parameters
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':phone_number', $phone_number);


        try {
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error message or handle it as needed
            return false;
        }
    }

    // Login user
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



    // Get user profile by user ID
    public function getUserProfile($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update user profile information
    public function updateProfile($userId, $data)
    {
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

        try {
            return $stmt->execute($values);
        } catch (PDOException $e) {
            // Log error message or handle it as needed
            return false;
        }
    }

    // Update profile picture
    public function updateProfilePicture($userId, $fileName)
    {
        $stmt = $this->db->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
        return $stmt->execute([$fileName, $userId]);
    }

    // Verify if a given password matches the stored password
    public function verifyPassword($userId, $currentPassword)
    {
        $stmt = $this->db->prepare("SELECT password FROM users WHERE user_id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user && password_verify($currentPassword, $user['password']);
    }

    // Update password
    public function updatePassword($userId, $newPassword)
    {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE user_id = ?");

        try {
            return $stmt->execute([$hashedPassword, $userId]);
        } catch (PDOException $e) {
            // Log error message or handle it as needed
            return false;
        }
    }
}


