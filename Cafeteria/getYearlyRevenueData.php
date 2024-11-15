<?php
header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
if ($mysqli->connect_error) {
    die(json_encode(['error' => $mysqli->connect_error]));
}

// Query to calculate monthly revenue
$query = "
    SELECT 
        MONTHNAME(created_at) AS month, 
        SUM(price * quantity_sold) AS revenue
    FROM products
    GROUP BY MONTH(created_at)
    ORDER BY MONTH(created_at)
";
$result = $mysqli->query($query);

$months = [];
$revenues = [];
while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $revenues[] = $row['revenue'];
}
echo json_encode(['months' => $months, 'revenues' => $revenues]);
$mysqli->close();
?>
