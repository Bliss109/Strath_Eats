<?php
require_once '../User/user.php';
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $password = $_POST['password'] ?? '';

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
        echo json_encode(["message" => "Invalid credentials"]);
    }
}
?>
