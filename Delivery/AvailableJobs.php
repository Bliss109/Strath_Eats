<?php
require_once 'load.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Jobs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="navbar-header" > 
    <img src="../Images/logoo.png" alt="StrathEats Logo" class="logo-image" />
        <?php $deliveryModule->navbar(); ?>
    </header>

    <main> 
        <h2> Available Jobs</h2>
        <section id="available jobs">
            <?php
            $userID=2;
            $deliveryModule->AvailableJobs($userID);?>
        </section>
    </main>
</body>
</html>