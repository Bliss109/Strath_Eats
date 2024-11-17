<?php
session_start();
$cafeteria = $_SESSION['selected_cafeteria'] ?? null;
if (!$cafeteria) {
    header('Location: Cafeteria.php'); // Redirect to cafeteria selection if not set
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $cafeteria; ?> - StrathEats</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
<aside class="sidebar1">
    <div class="sidebar-close">
        <i class="fa-solid fa-close"></i>
    </div>
    <h2>StrathEats</h2>
    <img src="../../Images/Logo.jpeg" alt="StrathEats Logo" class="logo-image">
    <nav>
        <ul>
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">Food Order</a></li>
            <li><a href="#">Favorite</a></li>
            <li><a href="#">Message</a></li>
            <li><a href="#">Order History</a></li>
            <li><a href="#">Bills</a></li>
            <li><a href="#">Login</a></li>
        </ul>
    </nav>
</aside>

<header class="header">
    <nav class="menu">
        <div class="burger-icons">
            <i class="fa-solid fa-bars"></i>
        </div>
        <div class="search--box">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" placeholder="Search">
        </div>
        <div class="menu--icons">
            <i class="fa-solid fa-bowl-food"></i>
            <div class="cart-icon">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>0</span>
            </div>
        </div>
    </nav>
</header>

<h1>Welcome to <?php echo htmlspecialchars($cafeteria); ?></h1>

<div class="content">
    <section class="cover">
        <div class="cover-overlay">
            <h1>
                <span class="slogan"><?php echo htmlspecialchars($cafeteria); ?> - Explore Our Menu!</span>
            </h1>
        </div>
    </section>

    <!-- Content for categories and food items -->
    <main>
        <h2 class="section-heading">Categories</h2>
        <div class="menu-list">
            <a href="breakfast.php">
                <div class="menu-item" id="starter-menu">
                    <img src="../../../Images/croissant.jpg" alt="Breakfast" />
                    <h5>Breakfast</h5>
                </div>
            </a>
            <a href="lunch.php">
                <div class="menu-item" id="main-course-menu">
                    <img src="../../../Images/beef.png" alt="Lunch" />
                    <h5>Lunch</h5>
                </div>
            </a>
            <a href="dessert.php">
                <div class="menu-item" id="dessert-menu">
                    <img src="../../../Images/Red_Velvet_Cake.png" alt="Dessert" />
                    <h5>Dessert</h5>
                </div>
            </a>
            <a href="drinks.php">
                <div class="menu-item" id="drinks-menu">
                    <img src="../../../Images/mirinda.png" alt="Beverages" />
                    <h5>Beverages</h5>
                </div>
            </a>
            <a href="snacks.php">
                <div class="menu-item" id="snacks-menu">
                    <img src="../../../Images/samosas.png" alt="Snacks" />
                    <h5>Snacks</h5>
                </div>
            </a>
        </div>

        <h2 class="section-heading">Food Items</h2>
        <!-- Dynamically generated food items -->
        <div id="food-items">
            <!-- Placeholder or dynamically generated content can go here -->
            <p>Coming soon...</p>
        </div>
    </main>
</div>

<footer class="footer">
    <p>© 2024 StrathEats. All rights reserved.</p>
</footer>
</body>
</html>
