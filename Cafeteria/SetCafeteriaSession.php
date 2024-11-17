<?php
session_start();

header('Content-Type: application/json');

// Retrieve JSON data from the request body
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['cafeteria']) && is_string($data['cafeteria'])) {
    // Set the selected cafeteria in the session with sanitization
    $_SESSION['selected_cafeteria'] = htmlspecialchars($data['cafeteria'], ENT_QUOTES, 'UTF-8');
    
    // Return success response
    http_response_code(200);
    echo json_encode(['message' => 'Cafeteria selected successfully']);
} else {
    // Return an error response for invalid or missing data
    http_response_code(400);
    echo json_encode(['error' => 'Invalid request: cafeteria not specified or invalid']);
}
?>
