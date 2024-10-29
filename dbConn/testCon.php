<?php
include_once 'Connection.php';
$database = new Database();
$conn = $database->getConnection();

if($conn){
    echo "Connnected Successfully ^_^";
}else{
    echo "Connection Failed!";
}
