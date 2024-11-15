<?php
require 'Connection.php'; // Ensure this file establishes a connection to the database
require 'testCon.php'; // Ensure this file establishes a connection to the database

$sql = "
    SELECT 
        oi.order_item_id,
        o.order_date,
        p.name AS product_name,
        oi.quantity,
        oi.price,
        (oi.quantity * oi.price) AS total_price
    FROM order_items oi
    JOIN orders o ON oi.order_id = o.order_id
    JOIN products p ON oi.product_id = p.product_id
    ORDER BY o.order_date ASC;
";

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($data);
?>
