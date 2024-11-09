<?php
session_start();
require_once '../User/user.php';  // Ensure this path is correct

// Check if the form is submitted and the profile picture is being updated
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_picture'])) {
    $userId = $_POST['user_id'];  // The user ID should be passed in the hidden input
    $user = new User();  // Create a new User object

    // Check if a file was uploaded and there were no errors
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === 0) {
        $file = $_FILES['profile_picture'];
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];  // Allowed image extensions
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));  // Get the file extension

        // Validate file type
        if (in_array($fileExtension, $allowedExtensions)) {
            $uploadDir = '../uploads/profile_pictures';  // Directory to store profile pictures

            // Check if the directory exists, if not, create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);  // Create the directory with appropriate permissions
            }

            // Create a unique filename to avoid collisions
            $fileName = uniqid('profile_', true) . '.' . $fileExtension;  
            $filePath = $uploadDir . '/' . $fileName;  // Full path to the file

            // Attempt to move the uploaded file to the desired directory
            if (move_uploaded_file($file['tmp_name'], $filePath)) {
                // Update the user's profile picture in the database
                if ($user->updateProfilePicture($userId, $fileName)) {
                    // If the update is successful, set the new profile picture URL in the session
                    $_SESSION['profile_picture'] = $fileName; // Save the new profile picture in the session
                    
                    // Redirect to the profile page or a confirmation page
                    header("Location: index.php");  // Redirect to the profile page to see the new picture
                    exit;  // Ensure no further code is executed after redirection
                } else {
                    echo "Failed to update profile picture in the database.";
                }
            } else {
                echo "Failed to move the uploaded file.";
            }
        } else {
            echo "Invalid file type. Only JPG, JPEG, PNG, and GIF are allowed.";
        }
    } else {
        echo "No file uploaded or there was an error with the upload.";
    }
  
}
?>
