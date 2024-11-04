<?php
session_start();

// Check if the user is logged in and is a cafeteria manager
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'manager') {
    header("Location: login.php"); // Redirect to login if not logged in or not a manager
    exit();
}

// Check if the manager is assigned to a specific cafeteria
$cafeteriaId = $_SESSION['cafeteria_id'] ?? null;
if (!$cafeteriaId) {
    echo "You are not assigned to any cafeteria.";
    exit();
}

// Sample personnel data
$personnelData = [
    'cafeteriaEmployees' => [
        ['name' => 'John Doe', 'role' => 'Cashier', 'shift' => 'Morning', 'contact' => 'john@example.com'],
        ['name' => 'Alice Green', 'role' => 'Server', 'shift' => 'Evening', 'contact' => 'alice@example.com']
    ],
    'deliveryPersonnel' => [
        ['name' => 'Tom White', 'role' => 'Delivery Driver', 'shift' => 'Full Day', 'contact' => 'tom@example.com']
    ],
    'kitchenStaff' => [
        ['name' => 'Emma Brown', 'role' => 'Head Chef', 'shift' => 'Full Day', 'contact' => 'emma@example.com']
    ],
    'supportStaff' => [
        ['name' => 'Robert Black', 'role' => 'Cleaner', 'shift' => 'Night', 'contact' => 'robert@example.com']
    ]
];

// Filter personnel data by cafeteria id (for demonstration, assume all personnel belong to the cafeteria)
echo json_encode($personnelData);
?>
