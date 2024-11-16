<?php
require_once 'load.php';
session_start();
$_SESSION["user_ID"] = 1;
$userID = $_SESSION["user_ID"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deliveries Dasboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar-header" > 
    <img src="../Images/logoo.png" alt="StrathEats Logo" class="logo-image" />
        <?php $deliveryModule->navbar(); ?>
    </header>

    <main>
        <h2> Pickup Jobs</h2>
        <section id="pickup-jobs">
        <?php $deliveryModule->currentPickupJobs($userID); ?>
        </section>

        <h2> Delivery Jobs </h2>
        <section id="delivery jobs">
        <?php $deliveryModule->CurrentDeliveryJobs($userID); ?>
        </section>

    </main>
</body>
</html>



