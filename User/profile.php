<?php
session_start();
<<<<<<< HEAD
require_once '../dbConn/Connection.php';

header('Content-Type: application/json' );
=======
require_once 'dbConn/Connection.php';
>>>>>>> 5adc3d3 (Updated profile)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo = (new Database())->getConnection();  
        
        
        $user_id = $_SESSION['user_id'] ?? null;
        if (empty($user_id)) {
            throw new Exception("User ID is required.");
        }

<<<<<<< HEAD
        $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE user_id = ?");
=======
        $stmt = $pdo->prepare("SELECT profile_picture FROM users WHERE id = ?");
>>>>>>> 5adc3d3 (Updated profile)
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            throw new Exception("User not found.");
        }

        if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = 'C:/xampp/htdocs/Strath_Eats/uploads/'; 

            $file_ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
            $allowed_exts = ['jpg', 'jpeg', 'png'];

            // Validate the file extension
            if (!in_array(strtolower($file_ext), $allowed_exts)) {
                throw new Exception("Invalid file type. Only JPG, JPEG, and PNG are allowed.");
            }

            // Validate the file size
            if ($_FILES['profile_picture']['size'] > 5 * 1024 * 1024) {
                throw new Exception("File size exceeds the 5MB limit.");
            }

            // Generate a unique file name
            $new_file_name = uniqid("profile_", true) . ".$file_ext";
            $target_path = $upload_dir . $new_file_name;

            // Move the uploaded file to the target directory
            if (!move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target_path)) {
                throw new Exception("Failed to upload profile picture.");
            }

            // Delete the old profile picture if it exists
            if (!empty($user['profile_picture'])) {
                $old_file_path = $upload_dir . $user['profile_picture'];
                if (file_exists($old_file_path)) {
                    unlink($old_file_path);
                }
            }

            // Update the database with the new profile picture file name
<<<<<<< HEAD
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE user_id = ?");
=======
            $stmt = $pdo->prepare("UPDATE users SET profile_picture = ? WHERE id = ?");
>>>>>>> 5adc3d3 (Updated profile)
            $stmt->execute([$new_file_name, $user_id]);

            // Update the session with the new profile picture path
            $_SESSION['profile_picture'] = $new_file_name;
<<<<<<< HEAD
            echo json_encode(["success" => "Profile picture updated successfully."]);
        } else {
            throw new Exception("No file uploaded or upload error.");
        }
=======

            echo "Profile picture updated successfully.";
        } else {
            throw new Exception("No file uploaded or upload error.");
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
>>>>>>> 5adc3d3 (Updated profile)
    } catch (Exception $e) {
        echo json_encode(["error" => $e->getMessage()]);
    }
<<<<<<< HEAD
}
=======
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method.']);
}
>>>>>>> 5adc3d3 (Updated profile)
