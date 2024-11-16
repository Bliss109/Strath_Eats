<?php
require_once '../User/user.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

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
    $terms = isset($inputData['terms']) ? true : false;

    // Basic validation to ensure fields are not empty
    if (empty($name) || empty($email) || empty($password) || empty($phone_number) || !$terms) {
        echo json_encode(["message" => "All fields are required!"]);
        exit;
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Further processing (e.g., saving to database)
    // Assuming you have a function to save the user data
    $user = new User();
    $result = $user->register($name, $email, $hashedPassword, $phone_number);

    if ($result) {
        echo json_encode(["message" => "Registration successful!"]);
    } else {
        echo json_encode(["message" => "Registration failed!"]);
    }

} else {
    // Handle invalid request method
    echo json_encode(["message" => "Invalid request method."]);
}
?>
