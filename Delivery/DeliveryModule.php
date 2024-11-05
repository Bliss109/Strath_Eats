<?php
class DeliveryModule {
    private $pdo;

    // Constructor to initialize PDO connection
    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dsn, $username, $password, $options);
    }

    // Function to display deliveries with "Add Delivery" buttons
    public function deliveries() {
        $stmt = $this->pdo->query("SELECT order_id, location, restaurant, client_id FROM orders WHERE type = 'delivery'");
        $orders = $stmt->fetchAll();

        echo "<table>";
        echo "<tr><th>Order ID</th><th>Location</th><th>Restaurant</th><th>Client ID</th><th>Action</th></tr>";
        foreach ($orders as $order) {
            echo "<tr>";
            echo "<td>{$order['order_id']}</td>";
            echo "<td>{$order['location']}</td>";
            echo "<td>{$order['restaurant']}</td>";
            echo "<td>{$order['client_id']}</td>";
            echo "<td><form method='POST'><input type='hidden' name='order_id' value='{$order['order_id']}'><button type='submit' name='add_delivery'>Add Delivery</button></form></td>";
            echo "</tr>";
        }
        echo "</table>";

        // Handle "Add Delivery" button action
        if (isset($_POST['add_delivery']) && isset($_POST['order_id'])) {
            $delivererId = $id; // Replace with actual deliverer ID from session or input
            $this->addDelivery($_POST['order_id'], $delivererId);
        }
    }

    // Function to add a delivery to the pickup table
    private function addDelivery($orderId, $delivererId) {
        // Get order details to add to pickup table
        $stmt = $this->pdo->prepare("SELECT order_id, location, client_id FROM orders WHERE order_id = :order_id AND type = 'delivery'");
        $stmt->execute(['order_id' => $orderId]);
        $order = $stmt->fetch();

        if ($order) {
            // Insert into pickup table
            $insertStmt = $this->pdo->prepare("INSERT INTO pickup (deliverer_id, client_id, location, order_id, status) VALUES (:deliverer_id, :client_id, :location, :order_id, 'pickup')");
            $insertStmt->execute([
                'deliverer_id' => $delivererId,
                'client_id' => $order['client_id'],
                'location' => $order['location'],
                'order_id' => $order['order_id']
            ]);
            echo "Delivery added for Order ID: $orderId";
        } else {
            echo "Order not found or is not a delivery.";
        }
    }

    // Function to pick a delivery and change status from pickup to delivery
    public function pickDelivery($orderId, $userId) {
        $stmt = $this->pdo->prepare("SELECT * FROM pickup WHERE order_id = :order_id AND deliverer_id = :deliverer_id AND status = 'pickup'");
        $stmt->execute(['order_id' => $orderId, 'deliverer_id' => $userId]);

        if ($stmt->rowCount() > 0) {
            $updateStmt = $this->pdo->prepare("UPDATE pickup SET status = 'delivery' WHERE order_id = :order_id AND deliverer_id = :deliverer_id");
            $updateStmt->execute(['order_id' => $orderId, 'deliverer_id' => $userId]);
            echo "Order ID: $orderId status updated to 'delivery'.";
        } else {
            echo "Order ID or User ID does not match, or order is not in 'pickup' status.";
        }
    }

    // Function to complete a delivery, moving the status in orders table to "complete"
    public function completeDelivery($orderId) {
        // Verify the order exists in the pickup table with status 'delivery'
        $stmt = $this->pdo->prepare("SELECT deliverer_id FROM pickup WHERE order_id = :order_id AND status = 'delivery'");
        $stmt->execute(['order_id' => $orderId]);
        $order = $stmt->fetch();
    
        if ($order) {
            $delivererId = $order['deliverer_id'];
            
            // Update the orders table and remove from pickup table
            $this->pdo->beginTransaction();
            try {
                // Mark order as complete in the orders table
                $this->pdo->prepare("UPDATE orders SET status = 'complete' WHERE order_id = :order_id")->execute(['order_id' => $orderId]);
                
                // Remove order from the pickup table
                $this->pdo->prepare("DELETE FROM pickup WHERE order_id = :order_id")->execute(['order_id' => $orderId]);
    
                // Add 30 to the balance of the deliverer in the users table
                $this->pdo->prepare("UPDATE users SET balance = balance + 30 WHERE user_id = :deliverer_id")->execute(['deliverer_id' => $delivererId]);
    
                $this->pdo->commit();
                echo "Order ID: $orderId marked as complete, and balance updated for Deliverer ID: $delivererId.";
            } catch (Exception $e) {
                $this->pdo->rollBack();
                echo "Failed to complete the order: " . $e->getMessage();
            }
        } else {
            echo "Order not found or not in 'delivery' status.";
        }
    }
    public function getBalance($delivererId) {
        // Prepare and execute the SQL statement to fetch the balance
        $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE user_id = :deliverer_id");
        $stmt->execute(['deliverer_id' => $delivererId]);
    
        // Fetch the balance
        $result = $stmt->fetch();
    
        if ($result) {
            return $result['balance'];
        } else {
            echo "Deliverer not found.";
            return null; // or return 0 if you'd like to return a default balance
        }
    }
}


?>

<!-- Form for picking up a delivery -->
<form method="POST">
    <label for="order_id">Order ID:</label>
    <input type="text" name="order_id" required>
    <label for="user_id">User ID:</label>
    <input type="text" name="user_id" required>
    <button type="submit" name="pick_delivery">Pick Delivery</button>
</form>

<!-- Form for completing a delivery -->
<form method="POST">
    <label for="complete_order_id">Order ID:</label>
    <input type="text" name="complete_order_id" required>
    <button type="submit" name="complete_delivery">Complete Delivery</button>
</form>
<?php
if (isset($_POST['pick_delivery'])) {
    $orderId = $_POST['order_id'];
    $userId = $_POST['user_id'];
    $deliveryModule->pickDelivery($orderId, $userId);
}

if (isset($_POST['complete_delivery'])) {
    $orderId = $_POST['complete_order_id'];
    $deliveryModule->completeDelivery($orderId);
}


?>
