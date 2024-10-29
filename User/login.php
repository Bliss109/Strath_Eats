<?php
<<<<<<< HEAD
require_once 'user.php';

=======
require_once '../User/user.php';
>>>>>>> master
session_start();

$data = json_decode(file_get_contents('php://input'), true);

<<<<<<< HEAD
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
   $email = $data['email'];
   $password = $data['password'];

   if(empty($email) || empty($password)){
    echo "Enter 'email' and 'password' to proceed";
     exit;
=======
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   // Check if $data is not null and contains required fields
   $email = isset($data['email']) ? filter_var($data['email'], FILTER_VALIDATE_EMAIL) : null;
   $password = isset($data['password']) ? $data['password'] : null;

   if (empty($email) || empty($password)) {
      echo "Enter 'email' and 'password' to proceed";
      exit;
>>>>>>> master
   }

   $user = new User();
   $userData = $user->login($email, $password);

<<<<<<< HEAD
   if($userData){

    $_SESSION['user'] = $userData;
    echo "Login Successful";
   }else{
    echo "Invalid email or Password";
   }
}
?>
=======
   if ($userData) {
      $_SESSION['user'] = $userData;
      echo "Login Successful";
   } else {
      echo "Invalid email or Password";
   }
}
>>>>>>> master
