<?php
include_once 'Connection.php';
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Connected Successfully ^_^";
} else {
    echo "Connection Failed!";
}
?>
