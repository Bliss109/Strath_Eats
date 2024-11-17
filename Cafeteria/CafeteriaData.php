<?php
require '../dbConn/Connection.php'; // Include your database connection script
require '../dbConn/testCon.php'; // Include your database connection script

header('Content-Type: application/json');

// Ensure the $conn variable is defined and is your MySQLi connection
try {
    // Query to fetch cafeterias
    $sql = "SELECT cafe_name, description, photo FROM cafeterias";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Fetch all results as an associative array
    $cafeterias = [];
    while ($row = $result->fetch_assoc()) {
        $cafeterias[] = $row;
    }

    // Free result set
    $result->free();

    // Return the data as JSON
    echo json_encode($cafeterias);
} catch (Exception $e) {
    // Return an error response
    http_response_code(500);
    echo json_encode(['error' => 'Failed to fetch cafeterias: ' . $e->getMessage()]);
}
?>

