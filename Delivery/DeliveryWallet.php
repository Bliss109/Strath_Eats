<?php
require_once 'load.php';
$deliveryModule->navbar();
$userId = 2;
$deliveryModule->Balance($userId);
//$deliveryModule->deliveryAnalysis($userId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wallet</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar-header" >
        <img src="../Images/logoo.png" alt="StrathEats Logo" class="logo-image" />
        <?php $deliveryModule->navbar(); ?>
    </header>

    <main>
        <h2> Wallet Balance</h2>
        <section id="wallet-balance">
            <?php $deliveryModule->Balance($userId); ?>
        </section>

        <h2> Delivery Analysis </h2>
        <section id="delivery-analysis">
            <?php $deliveryModule->deliveryAnalysis($userId); ?>
        </section>
    </main>
</body>
</html>


