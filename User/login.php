<?php
require_once '../User/user.php';
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if ($data === null) {
    echo json_encode(["message" => "No data received or JSON is malformed."]);
    exit;
}

$name = $data['name'] ?? '';
$password = $data['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($name) || empty($password)) {
        echo json_encode(["message" => "Both name and password are required!"]);
        exit;
    }

    $user = new User();
    $result = $user->login($name, $password);

    if ($result['success']) {
        $_SESSION['user_id'] = $result['user_id'];
        echo json_encode(["message" => "Login Successful"]);
    } else {
        echo json_encode(["message" => $result['error']]);
    }
}
?>

