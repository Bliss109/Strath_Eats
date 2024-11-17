<?php
session_start();

// Simulated database data for cafeterias
// $cafeterias = [
//     'Groundfloor' => [
//         'name' => 'Groundfloor Cafeteria',
//         'description' => 'Plenty of dining space and a wide variety of food options.',
//         'image' => 'images/cafeteria.jpg',
//         'session_value' => 'Groundfloor',
//     ],
//     'SpringsOfOlive' => [
//         'name' => 'Springs of Olive Cafeteria',
//         'description' => 'Famously known for its chips and wings.',
//         'image' => 'images/cafeteria2.jpg',
//         'session_value' => 'SpringsOfOlive',
//     ],
//     'Pate' => [
//         'name' => 'Pate Cafeteria',
//         'description' => 'Culinary delights from around the world.',
//         'image' => 'images/cafeteria1.jpg',
//         'session_value' => 'Pate',
//     ],
//     'CoffeeBar' => [
//         'name' => 'Coffee Bar',
//         'description' => 'Delicious coffee and milkshakes.',
//         'image' => 'images/cafeteria3.jpg',
//         'session_value' => 'CoffeeBar',
//     ],
// ];
require '../dbConn/Connection.php'; 
require '../dbConn/testCon.php';

// Handle cafeteria selection
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cafeteria'])) {
    $selectedCafeteria = $_POST['cafeteria'];
    if (array_key_exists($selectedCafeteria, $cafeterias)) {
        $_SESSION['selected_cafeteria'] = $cafeterias[$selectedCafeteria];
        header('Location: ../../index.php'); // Redirect to index.php
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CafeteriaStyle.css">
    <title>Cafeterias</title>
</head>
<body>
<header>
    <h1>Available Cafeterias</h1>
</header>
<div class="cafeteria-container" id="cafeteriaList">
      <!-- JavaScript will dynamically insert cafeteria cards here -->
</div>

<!-- Include the external JavaScript file -->
<script src="CafeteriaScript.js"></script>

</body>
</html>
