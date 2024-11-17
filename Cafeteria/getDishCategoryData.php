<?php
require '../../../dbConn/Connection.php'; 
require '../dbConn/testCon.php';
header('Content-Type: application/json');


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
