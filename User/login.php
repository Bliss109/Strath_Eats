<?php
require_once 'user.php';

session_start();

$data = json_decode(file_get_contents('php://input'), true);

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   $email = $data['email'];
   $password = $data['password'];

   if(empty($email) || empty($password)){
    echo "Enter 'email' and 'password' to proceed";
     exit;
   }

   $user = new User();
   $userData = $user->login($email, $password);

   if($userData){

    $_SESSION['user'] = $userData;
    echo "Login Successful";
   }else{
    echo "Invalid email or Password";
   }
}
?>