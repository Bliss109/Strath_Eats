<?php
header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
if ($mysqli->connect_error) {
    die(json_encode(['error' => $mysqli->connect_error]));
}

// Query to fetch items with low stock quantity
$query = "
    SELECT 
        name, 
        stock_quantity
    FROM products
    WHERE stock_quantity <= 10
    ORDER BY stock_quantity ASC
";
$result = $mysqli->query($query);

$items = [];
$counts = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row['name'];
    $counts[] = $row['stock_quantity'];
}
echo json_encode(['items' => $items, 'counts' => $counts]);
$mysqli->close();
?>
