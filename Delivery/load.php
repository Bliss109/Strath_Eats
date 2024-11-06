<?php
require_once 'DeliveryModule.php';

// Initialize the DeliveryModule instance with your database credentials
$deliveryModule = new DeliveryModule("localhost", "database_name", "username", "password");

// Display the table of deliveries (calling the deliveries method)
$deliveryModule->deliveries();
?>