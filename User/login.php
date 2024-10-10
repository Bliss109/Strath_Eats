<?php
require_once '../User/user.php';
session_start();

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // Check if $data is not null and contains required fields
   $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
   $password = isset($data['password']) ? $data['password'] : null;

   if (empty($email) || empty($password)) {
      echo "Enter 'email' and 'password' to proceed";
      exit;
   }

   $user = new User();
   $userData = $user->login($email, $password);

   if ($userData) {
      $_SESSION['user'] = $userData;
      echo "Login Successful";
   } else {
      echo "Invalid email or Password";
   }
}
