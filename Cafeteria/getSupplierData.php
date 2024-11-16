<?php
require '../dbConn/Connection.php'; 
require '../dbConn/testCon.php';
header('Content-Type: application/json');



// Query to fetch supplier delivery frequency
$query = "
    SELECT 
        name, 
        delivery_frequency
    FROM suppliers
";
$result = $mysqli->query($query);

$names = [];
$frequencies = [];
while ($row = $result->fetch_assoc()) {
    $names[] = $row['name'];
    $frequencies[] = $row['delivery_frequency'];
}
echo json_encode(['names' => $names, 'frequencies' => $frequencies]);
$mysqli->close();
?>
