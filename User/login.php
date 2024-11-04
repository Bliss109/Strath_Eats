<?php
require_once '../dbConn/Connection.php';

class User {
    private $conn;
    private $table = 'users';

    public function __construct() {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function register($name, $email, $password) {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO " . $this->table . " (name, email, password) VALUES (:name, :email, :password)";
            $stmt = $this->conn->prepare($sql);

            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Registration error: " . $e->getMessage());
            return false;
        }
    }

    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if (password_verify($password, $user['password'])) {
                    return ["status" => "success", "user" => $user];
                } else {
                    return ["status" => "error", "message" => "Invalid password"];
                }
            } else {
                return ["status" => "error", "message" => "User not found"];
            }
        } catch (PDOException $e) {
            error_log("Login error: " . $e->getMessage());
            return ["status" => "error", "message" => "Database error occurred"];
        }
    }
}
?>

