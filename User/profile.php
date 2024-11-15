<?php
require_once 'dbConn/Connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = (new Database())->getConnection();  
        
        $user_id = $_POST['user_id'] ?? null;
        if (empty($user_id)) {
            throw new Exception("User ID is required.");
        }

        
        $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new Exception("User not found.");
        }

        
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/profile_pictures/';
            if (!is_dir($upload_dir)) {
                if (!mkdir($upload_dir, 0777, true)) {
                    throw new Exception("Failed to create upload directory.");
                }
            }

            $file_name = basename($_FILES['profile_picture']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png'];

            if (!in_array($file_ext, $allowed_exts)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
            }

            if ($_FILES['profile_picture']['size'] > 5 * 1024 * 1024) { 
                throw new Exception("File size exceeds the 5MB limit.");
            }

            
            $new_file_name = uniqid("profile_", true) . ".$file_ext";
            $target_path = $upload_dir . $new_file_name;

            
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
                throw new Exception("Failed to upload profile picture.");
            }

            
            if (!empty($user['profile_picture'])) {
                $old_file_path = $upload_dir . $user['profile_picture'];
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
            $stmt->execute([$new_file_name, $user_id]);
        }

        
        $stmt = $pdo->prepare("
            UPDATE users SET
                first_name = :first_name,
                last_name = :last_name,
                email = :email,
                phone = :phone,
                gender = :gender,
                dob = :dob,
                student_id = :student_id,
                role = :role
            WHERE id = :user_id
        ");
        $stmt->execute([
            ':first_name' => $_POST['first_name'] ?? null,
            ':last_name' => $_POST['last_name'] ?? null,
            ':email' => $_POST['email'] ?? null,
            ':phone' => $_POST['phone'] ?? null,
            ':gender' => $_POST['gender'] ?? null,
            ':dob' => $_POST['dob'] ?? null,
            ':student_id' => $_POST['student_id'] ?? null,
            ':role' => $_POST['role'] ?? null,
            ':user_id' => $user_id,
        ]);

        echo json_encode(['message' => 'Profile updated successfully.']);
    } catch (Exception $e) {
        http_response_code(400);
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method.']);
}
