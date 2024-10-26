<?php
require_once 'user.php';

$data = json_decode(file_get_contents('php://input'), true);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];

    if(empty($name) || empty($email) || empty($password)){
        echo "All fields are required!";
        exit;
    }

  $user = new User();
  if($user->register($name, $email, $password)){
    echo "Registered Successful";
  }else{
    echo "registration failed";
  }
}
?>