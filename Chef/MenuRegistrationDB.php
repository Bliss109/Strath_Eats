<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Cafeteria Manager') {
    header("Location: login.php");
    exit();
}

// Database connection
$host = 'localhost';
$dbname = 'strath_eats';
$username = 'root';
$password = '';

$db = new mysqli($host, $username, $password, $dbname);

if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['menuName'];
    $description = $_POST['menuDescription'];
    $price = $_POST['menuPrice'];
    $category = $_POST['menuCategory'];
    $prepTime = $_POST['prepTime'];
    $allergens = $_POST['allergens'];
    $imagePath = '';

    // Image upload handling
    if (isset($_FILES['menuImage']) && $_FILES['menuImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($_FILES['menuImage']['name']);
        if (!move_uploaded_file($_FILES['menuImage']['tmp_name'], $imagePath)) {
            die("Failed to upload image.");
        }
    }

    // Insert into products table
    $stmt = $db->prepare("INSERT INTO products (name, description, price, category, preparation_time, allergens, picture, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdssss", $name, $description, $price, $category, $prepTime, $allergens, $imagePath);

    if ($stmt->execute()) {
        echo "Dish registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
    $db->close();
}
?>
