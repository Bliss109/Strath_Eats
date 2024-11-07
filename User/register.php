<?php
require_once '../User/user.php';

header('Content-Type: application/json'); // Specify response format as JSON

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if ($data === null) {
    echo json_encode(["message" => "No data received or JSON is malformed."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $phone_number = $data['phone_number'] ?? ''; // Fixed variable name

    if (empty($name) || empty($email) || empty($password) || empty($phone_number)) {
        echo json_encode(["message" => "All fields are required!"]);
        exit;
    }

    $user = new User();
    if ($user->register($name, $email, $password, $phone_number)) {
        echo json_encode(["message" => "Registration Successful"]);
    } else {
        echo json_encode(["message" => "Registration failed"]);
    }
}
?>
