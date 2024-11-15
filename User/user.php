<?php
require_once '../dbConn/Connection.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
    }

    // Register a new user
    public function register($name, $email, $password, $phone_number)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name, email, password, phone_number) VALUES (:name, :email, :password, :phone_number)";
        $stmt = $this->db->prepare($sql);

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
    public function login($name, $password)
{
      // Trim whitespace from the name to avoid unintended issues
      $name = trim($name);
    // Fetch the user by name
    $query = "SELECT * FROM users WHERE name = :name";
    $stmt = $this->db->prepare($query);

    // Bind the parameter
    $stmt->bindParam(":name", $name);

    // Execute the query
    $stmt->execute();

    // Fetch the result
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Debug output to check hashed password in DB
        echo "Stored hashed password: " . $user['password'] . "<br>";

        // Verify the password
        if (password_verify($password, $user['password'])) {
            echo "Password matched!";
            return ["success" => true, "user_id" => $user['user_id']];
        } else {
            echo "Password does not match.<br>";
        }
    } else {
        echo "User not found.<br>";
    }

    return ["success" => false, "error" => "Invalid username or password."];
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

