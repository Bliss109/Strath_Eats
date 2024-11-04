<?php
require_once '../User/user.php';
session_start();

// At the top of login.php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if ($data === null) {
   echo json_encode(["message" => "No data received or JSON is malformed."]);
   exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   $name = $data['name'] ?? '';
   $password = $data['password'] ?? '';

   if (empty($name) || empty($password)) {
      echo json_encode(["message" => "Both name and password are required!"]);
      exit;
   }

   $user = new User();
   // Assuming the User class has a method named 'login' for authentication
   if ($user->login($name, $password)) {
      // Here you can set session or token for the logged-in user
      echo json_encode(["message" => "Login Successful"]);
   } else {
      echo json_encode(["message" => "Invalid User Name or password"]);
   }
}
?>
