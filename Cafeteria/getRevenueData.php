<?php
header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
if ($mysqli->connect_error) {
    die(json_encode(['error' => $mysqli->connect_error]));
}

// Query to calculate total revenue for each product
$query = "
    SELECT 
        name, 
        price, 
        SUM(quantity_sold) AS quantitySold
    FROM products
    GROUP BY name, price
";
$result = $mysqli->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}
echo json_encode($data);
$mysqli->close();
?>
