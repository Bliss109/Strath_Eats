<?php
header('Content-Type: application/json');

// Database connection
$mysqli = new mysqli('DB_HOST', 'DB_USER', 'DB_PASS', 'DB_NAME');
if ($mysqli->connect_error) {
    die(json_encode(['error' => $mysqli->connect_error]));
}

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
