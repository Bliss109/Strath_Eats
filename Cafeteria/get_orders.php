<?php
header("Content-Type: application/json");
include 'Connection.php'; // Your database connection file

$sql = "SELECT order_id, user_id, order_time, payment_status FROM orders ORDER BY order_time DESC";
$result = $conn->query($sql);

$orders = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

echo json_encode($orders);
$conn->close();
?>
