<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Cafeteria_Manager') {
    header("Location: login.php");
    exit();
}

require 'Connection.php';
require 'testCon.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST['menuName'];
    $description = $_POST['menuDescription'];
    $price = $_POST['menuPrice'];
    $category = $_POST['menuCategory'];
    $prepTime = $_POST['prepTime'];
    $allergens = $_POST['allergens'];
    $cafeteria = $_POST['cafeteria']; // Retrieve cafeteria selection
    $imagePath = '';

    // Image upload handling
    if (isset($_FILES['menuImage']) && $_FILES['menuImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        $imagePath = $uploadDir . basename($_FILES['menuImage']['name']);
        if (!move_uploaded_file($_FILES['menuImage']['tmp_name'], $imagePath)) {
            die("Failed to upload image.");
        }
    }

    // Insert into products table, including cafeteria column
    $stmt = $db->prepare("INSERT INTO products (name, description, price, category, preparation_time, allergens, picture, cafeteria, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssdsssss", $name, $description, $price, $category, $prepTime, $allergens, $imagePath, $cafeteria);

    if ($stmt->execute()) {
        echo "<script>alert('Dish registered successfully!'); window.location.href = 'MenuRegistration.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }
    $stmt->close();
    $db->close();
}
?>
