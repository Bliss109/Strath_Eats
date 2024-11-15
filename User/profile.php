<?php
require_once 'dbConn\Connection.php'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        
        $user_id = $_POST['user_id'];
        if (empty($user_id)) {
            throw new Exception("User ID is required.");
        }

        
        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../uploads/profile_pictures/';
            $file_name = basename($_FILES['profile_picture']['name']);
            $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png'];

            if (!in_array($file_ext, $allowed_exts)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
            }

            $new_file_name = uniqid("profile_", true) . ".$file_ext";
            $target_path = $upload_dir . $new_file_name;

            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
                throw new Exception("Failed to upload profile picture.");
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

        echo "Profile updated successfully.";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request method.";
}
?>
