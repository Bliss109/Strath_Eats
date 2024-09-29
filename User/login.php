<?php
require_once 'user.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   $email = $_POST['email'];
   $password = $_POST['password'];

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