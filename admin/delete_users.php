<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strath_eats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $delete_user_query = "DELETE FROM users WHERE user_id = $id";

    if ($conn->query($delete_user_query) === TRUE) {
        header("Location: display_users.php");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
} else {
    echo "No user ID provided.";
    exit();
}

$conn->close();
?>

