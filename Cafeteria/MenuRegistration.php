<?php

session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Cafeteria_Manager') {
    header("Location:Index Page 2/landing.html");
    exit();
} 


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="MenuRegistrationStyle.css">
    <title>Dish Registration</title>
    <script src="MenuRegistration.js" defer></script>
</head>
<body>
    <form id="MenuForm" action="MenuRegistrationDB.php" method="POST" enctype="multipart/form-data">
        <div class="MenuRegistration-container">
            <center><h1>Dish Registration</h1></center>

            <label for="menuName">Dish Name</label>
            <input type="text" id="menuName" name="menuName" placeholder="Enter Dish Name"><br>
            <span class="error" id="menuNameError"></span>

            <label for="menuDescription">Dish Description</label>
            <textarea id="menuDescription" name="menuDescription" placeholder="Enter Dish Description"></textarea><br>
            <span class="error" id="menuDescriptionError"></span>

            <label for="menuPrice">Price</label>
            <input type="text" id="menuPrice" name="menuPrice" placeholder="Enter Price"><br>
            <span class="error" id="menuPriceError"></span>

            <label for="menuCategory">Category</label>
            <select id="menuCategory" name="menuCategory">
                <option value="Breakfast">Breakfast</option>
                <option value="Main Course">Lunch</option>
                <option value="Snacks">Snacks</option>
                <option value="Dessert">Dessert</option>
                <option value="Drinks">Drinks</option>
            </select><br>
            <span class="error" id="menuCategoryError"></span>

            <label for="prepTime">Preparation Time (in minutes)</label>
            <input type="number" id="prepTime" name="prepTime" placeholder="Enter Preparation Time"><br>
            <span class="error" id="prepTimeError"></span>

            <label for="allergens">Allergen Notice</label>
            <textarea id="allergens" name="allergens" placeholder="Enter any allergens in the dish"></textarea><br>
            <span class="error" id="allergensError"></span>

            <label for="menuImage">Dish Image</label>
            <input type="file" id="menuImage" name="menuImage"><br>
            <span class="error" id="menuImageError"></span>

            <label for="Cafeteria">Cafeteria</label>
            <select id="cafeteria" name="cafeteria">
                <option value="Groundfloor">Groundfloor</option>
                <option value="Springs of Olive">Springs of Olive</option>
                <option value="Pate Cafeteria">Pate Cafeteria</option>
                <option value="Coffee Bar">Coffee Bar</option>
            </select><br>

            <button type="submit">Submit</button>
        </div>
    </form>
    <footer class="footer">&copy; 2024 StrathEats. All rights reserved.</footer>
</body>
</html>
