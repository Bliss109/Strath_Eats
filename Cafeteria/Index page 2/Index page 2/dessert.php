<?php
require '../../../dbConn/Connection.php'; // Your database connection file
require '../../../dbConn/testCon.php'; 

// Fetch desserts for the respective cafeteria
$cafeteria_id = isset($_GET['cafeteria_id']) ? intval($_GET['cafeteria_id']) : 1; // Default to cafeteria ID 1
$sql = "SELECT name, description, price, picture FROM products WHERE category = 'Dessert' AND cafeteria_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cafeteria_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch rows as an associative array
$desserts = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dessert Menu - StrathEats</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar1">
        <div class="sidebar-close">
            <i class="fa-solid fa-close"></i>
        </div>
        <h2>StrathEats</h2>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li><a href="index.php">Food Order</a></li>
                <li><a href="#">Favorite</a></li>
                <li><a href="#">Message</a></li>
                <li><a href="#">Order History</a></li>
                <li><a href="#">Bills</a></li>
                <li><a href="#">Login</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Header -->
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

    <!-- Main Content -->
    <div class="content">
        <h1>Dessert Menu</h1>
        <section class="cover">
            <div class="cover-overlay">
                <h1>
                    <span class="slogan">Satisfy Your Sweet Tooth!</span>
                </h1>
            </div>
        </section>

        <main>
            <!-- Dessert Items Section -->
            <h2 class="section-heading">Available Dessert Items</h2>
            <div class="card-list">
                <?php if (!empty($desserts)): ?>
                    <?php foreach ($desserts as $dessert): ?>
                        <div class="card">
                            <img src="<?php echo htmlspecialchars($dessert['picture']); ?>" alt="<?php echo htmlspecialchars($dessert['name']); ?>">
                            <h4 class="card-title"><?php echo htmlspecialchars($dessert['name']); ?></h4>
                            <p class="card-description"><?php echo htmlspecialchars($dessert['description']); ?></p>
                            <div class="card-price">
                                <span class="price">Ksh <?php echo htmlspecialchars($dessert['price']); ?></span>
                                <i class="fa-solid fa-plus add-to-cart"></i>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No desserts available at this time.</p>
                <?php endif; ?>
            </div>

            <div class="sidebar" id="sidebar">
                <div class="cart-items">
                    <div class="sidebar-close">
                        <i class="fa-solid fa-close"></i>
                    </div>
                    <div class="cart-menu">
                        <h3>My Cart</h3>
                        <div class="cart-tems"></div>
                    </div>
                    <div class="sidebar-footer">
                        <div class="total-amount">
                            <h5>Total</h5>
                            <div class="cart-total">Ksh0.00</div>
                        </div>
                        <button class="checkout-btn">Checkout</button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <footer class="footer">
        <p>© 2024 StrathEats. All rights reserved.</p>
    </footer>

    <script src="main.js"></script>
</body>
</html>
