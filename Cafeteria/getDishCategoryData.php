<?php
header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
if ($mysqli->connect_error) {
    die(json_encode(['error' => $mysqli->connect_error]));
}

// Query to calculate total sales by category
$query = "
    SELECT 
        category, 
        SUM(price * quantity_sold) AS totalSales
    FROM products
    GROUP BY category
";
$result = $mysqli->query($query);

$categories = [];
$sales = [];
while ($row = $result->fetch_assoc()) {
    $categories[] = $row['category'];
    $sales[] = $row['totalSales'];
}
echo json_encode(['categories' => $categories, 'sales' => $sales]);
$mysqli->close();
?>
