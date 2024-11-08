<?php
session_start();
// Include the DeliveryModule class file
require_once 'DeliveryModule.php';

// Initialize the DeliveryModule instance with your database credentials
$deliveryModule = new DeliveryModule("localhost", "database_name", "username", "password");

// Display the table of deliveries (calling the deliveries method)
$deliveryModule->deliveries();

// Handle the form submissions for picking up and completing deliveries
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle the Add Delivery form action (triggered by "Add Delivery" button in deliveries method)
    if (isset($_POST['add_delivery']) && isset($_POST['order_id'])) {
        $delivererId = 123; // Replace this with the actual deliverer ID from session or input
        $orderId = $_POST['order_id'];
        $deliveryModule->addDelivery($orderId, $delivererId);
    }

    // Handle the Pick Delivery form action
    if (isset($_POST['pick_delivery'])) {
        $orderId = $_POST['order_id'];
        $userId = $_POST['user_id'];
        $deliveryModule->pickDelivery($orderId, $userId);
    }

    // Handle the Complete Delivery form action
    if (isset($_POST['complete_delivery'])) {
        $orderId = $_POST['complete_order_id'];
        $deliveryModule->completeDelivery($orderId);
    }
}
$DeliveryModule = new DeliveryModule("localhost", "database_name", "username", "password");
$DeliveryModule->deliveries();
?>
