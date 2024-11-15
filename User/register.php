<?php
require_once '../User/user.php';

// Set the response header to JSON format
header('Content-Type: application/json');

// Handle POST requests
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Retrieve JSON input data
    $inputData = json_decode(file_get_contents("php://input"), true);
    
    // Check if the input data exists and is an array
    if (empty($inputData)) {
        echo json_encode(["message" => "Invalid input data."]);
        exit;
    }

    // Retrieve form data from the decoded JSON
    $name = $inputData['name'] ?? '';
    $email = $inputData['email'] ?? '';
    $password = $inputData['password'] ?? '';
    $phone_number = $inputData['phone_number'] ?? '';

    // Basic validation to ensure fields are not empty
    if (empty($name) || empty($email) || empty($password) || empty($phone_number)) {
        echo json_encode(["message" => "All fields are required!"]);
        exit;
    }

    // Sanitize email
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(["message" => "Invalid email format."]);
        exit;
    }

    // Password hashing for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Create a new User object and attempt registration
    $user = new User();
    $registrationResult = $user->register($name, $email, $hashedPassword, $phone_number);

    if ($registrationResult) {
        echo json_encode(["message" => "Registration Successful"]);
    } else {
        echo json_encode(["message" => "Registration failed"]);
    }

} else {
    // Handle invalid request method
    echo json_encode(["message" => "Invalid request method."]);
}
?>

