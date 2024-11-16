<?php
require '../dbConn/Connection.php';
require '../dbConn/testCon.php';
header('Content-Type: application/json');



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
