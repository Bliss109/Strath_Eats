<?php
session_start();
require '../dbConn/Connection.php';
require '../dbConn/testCon.php';
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
