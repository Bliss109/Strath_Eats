<?php
require_once 'load.php';
session_start();
$_SESSION["user_ID"] = 2;
$userID = $_SESSION["user_ID"];
$deliveryModule->navbar();
$deliveryModule->currentPickupJobs($userID);
$deliveryModule->CurrentDeliveryJobs($userID);
?>