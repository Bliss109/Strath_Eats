<?php
// Function to fetch pending withdrawals
function getPendingWithdrawals($conn) {
    $query = "SELECT withdrawal_id, user_id, amount FROM withdrawals WHERE status = 'pending'";
    return $conn->query($query);
}

// Handle the confirm button click
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    $withdrawal_id = intval($_POST['withdrawal_id']);
    $user_id = intval($_POST['user_id']);
    $amount = floatval($_POST['amount']);

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "strath_eats";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    try {
        $query1 = $conn->prepare("UPDATE withdrawals SET status = 'completed' WHERE withdrawal_id = ?");
        $query1->bind_param("i", $withdrawal_id);
        $query1->execute();

        $query2 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE user_id = ?");
        $query2->bind_param("di", $amount, $user_id);
        $query2->execute();

        $query3 = $conn->prepare("UPDATE users SET balance = balance - ? WHERE role = 'admin'");
        $query3->bind_param("d", $amount);
        $query3->execute();

        $conn->commit();

        echo "<p style='text-align: center; color: green;'>Withdrawal ID $withdrawal_id confirmed successfully.</p>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<p style='text-align: center; color: red;'>Error confirming withdrawal: " . $e->getMessage() . "</p>";
    } finally {
        $conn->close();
    }
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "strath_eats";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Withdrawals</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Pending Withdrawals</h1>
    <?php
    $results = getPendingWithdrawals($conn);
    if ($results && $results->num_rows > 0) {
        echo "<table>";
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
        echo "<p style='text-align: center;'>No pending withdrawals.</p>";
    }
    $conn->close();
    ?>
    <footer>&copy; <?php echo date('Y'); ?> StrathEats. All rights reserved.</footer>
</body>
</html>
