<?php
function displayPendingWithdrawals($conn) {
    // Query to fetch pending withdrawals
    $query = "SELECT withdrawal_id, user_id, amount FROM withdrawals WHERE status = 'pending'";
    $results = $conn->query($query);

    // Check if there are results
    if ($results && $results->num_rows > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Withdrawal ID</th><th>User ID</th><th>Amount</th><th>Action</th></tr>";

        while ($row = $results->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['withdrawal_id']}</td>";
            echo "<td>{$row['user_id']}</td>";
            echo "<td>{$row['amount']}</td>";
            echo "<td>
                    <form method='POST'>
                        <input type='hidden' name='withdrawal_id' value='{$row['withdrawal_id']}'>
                        <input type='hidden' name='user_id' value='{$row['user_id']}'>
                        <input type='hidden' name='amount' value='{$row['amount']}'>
                        <button type='submit' name='confirm'>Confirm</button>
                    </form>
                  </td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "No pending withdrawals.";
    }
}

// Handle the confirm button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    // Sanitize and validate inputs
    $withdrawal_id = intval($_POST['withdrawal_id']);
    $user_id = intval($_POST['user_id']);
    $amount = floatval($_POST['amount']);

    // Database credentials
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "strath_eats";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update withdrawal status
        $query1 = $conn->prepare("UPDATE withdrawals SET status = 'completed' WHERE withdrawal_id = ?");
        $query1->bind_param("i", $withdrawal_id);
        $query1->execute();

        // Deduct amount from user's balance
        $query2 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE user_id = ?");
        $query2->bind_param("di", $amount, $user_id);
        $query2->execute();

        // Deduct amount from admin's balance
        $query3 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE role = 'admin'");
        $query3->bind_param("d", $amount);
        $query3->execute();

        // Commit transaction
        $conn->commit();

        echo "Withdrawal ID $withdrawal_id confirmed successfully.";
    } catch (Exception $e) {
        // Rollback transaction in case of error
        $conn->rollback();
        echo "Error confirming withdrawal: " . $e->getMessage();
    } finally {
        $conn->close();
    }
}

// Establish database connection and display withdrawals
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strath_eats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

displayPendingWithdrawals($conn);
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Withdrawals</title>
    <!-- Link to your CSS file -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Pending Withdrawals</h1>
    <?php
    // Display pending withdrawals
    displayPendingWithdrawals($conn);
    $conn->close();
    ?>

<footer>&copy; <?php echo date('Y'); ?> StrathEats. All rights reserved.</footer>
</body>
</html>