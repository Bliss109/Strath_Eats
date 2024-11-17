<?php
require '../dbConn/Connection.php'; // Include database connection file

header('Content-Type: application/json');

try {
    // Query to fetch cafeterias, including required fields for the frontend
    $sql = "SELECT cafe_name AS name, description, photo AS image FROM cafeterias";
    $result = $conn->query($sql);

    if (!$result) {
        throw new Exception("Query failed: " . $conn->error);
    }

    // Fetch all results as an associative array
    $cafeterias = [];
    while ($row = $result->fetch_assoc()) {
        // Ensure `photo` has a default placeholder if NULL
        $row['image'] = $row['image'] ?? '../images/default-image.jpg';
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
} finally {
    $conn->close();
}
?>
