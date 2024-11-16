<?php
require '../dbConn/Connection.php'; 
require '../dbConn/testCon.php';
header('Content-Type: application/json');


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
