<?php
require_once 'user.php';


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($name) || empty($email) || empty($pasword)){
        echo "All fields are required!";
        exit;
    }

  $user = new User();
  if($user->register($name, $email, $passsword)){
    echo "Registered Successful";
  }else{
    echo "registration failed";
  }
}
?>