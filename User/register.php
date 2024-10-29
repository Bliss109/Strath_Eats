<?php
<<<<<<< HEAD
require_once 'user.php';

$data = json_decode(file_get_contents('php://input'), true);

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $data['name'];
    $email = $data['email'];
    $password = $data['password'];
=======
require_once '../User/user.php';

$rawData = file_get_contents('php://input');
$data = json_decode($rawData, true);

if ($data === null) {
    echo "No data received or JSON is malformed.";
    exit;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $data['name'] ?? '';
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
>>>>>>> master

    if(empty($name) || empty($email) || empty($password)){
        echo "All fields are required!";
        exit;
    }

<<<<<<< HEAD
  $user = new User();
  if($user->register($name, $email, $password)){
    echo "Registered Successful";
  }else{
    echo "registration failed";
  }
}

?>
=======
    $user = new User();
    if($user->register($name, $email, $password)){
        echo "Registration Successful";
    } else {
        echo "Registration failed";
    }
}
?>
>>>>>>> master
