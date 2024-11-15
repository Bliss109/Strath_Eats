<?php
require 'Connection.php';
require 'testCon.php'; 
header('Content-Type: application/json');



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
