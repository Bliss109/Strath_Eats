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
    
    public function navbar() {
        echo '
        <nav>
            <ul>
                <li><a href="DeliveryHome.php">Home</a></li>
                <li><a href="DeliveryProfile.php">Profile</a></li>
                <li><a href="DeliveryWallet.php">Wallet</a></li>
                <li><a href="AvailableJobs.php">Available Jobs </a></li>
                <li><a href="#">Logout</a></li>
            </ul>
        </nav>
        ';
    }

    public function AvailableJobs($userId) {
        // Fetch available jobs with status 'pending' from the deliveries table
        $stmt = $this->pdo->prepare("SELECT order_id, delivery_location FROM deliveries WHERE delivery_status = 'pending'");
        $stmt->execute();
        $jobs = $stmt->fetchAll();
    
        if ($jobs) {
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Delivery Location</th><th>Action</th></tr>";
    
            foreach ($jobs as $job) {
                echo "<tr>";
                echo "<td>{$job['order_id']}</td>";
                echo "<td>{$job['delivery_location']}</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='order_id' value='{$job['order_id']}'>
                            <button type='submit' name='take_job'>Take Job</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
    
            // Handle Take Job button action
            if (isset($_POST['take_job']) && isset($_POST['order_id'])) {
                $orderId = $_POST['order_id'];
                $this->assignJobToDeliverer($orderId, $userId);
            }
        } else {
            echo "No available jobs at the moment.";
        }
    }
    

    public function deliveries() {
        $stmt = $this->pdo->query("SELECT order_id, location, restaurant, client_id FROM orders WHERE type = 'delivery'");
        $orders = $stmt->fetchAll();

        echo "The available jobs are:";
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
    public function currentPickupJobs($userId) {
        // Fetch current jobs from the deliveries table
        $stmt = $this->pdo->prepare("SELECT order_id, delivery_status, delivery_location FROM deliveries WHERE deliverer_id = :user_id AND delivery_status = 'pickup'");
        $stmt->execute(['user_id' => $userId]);
        $jobs = $stmt->fetchAll();
    
        if ($jobs) {
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Delivery Status</th><th>Delivery Location</th><th>Action</th></tr>";
    
            foreach ($jobs as $job) {
                echo "<tr>";
                echo "<td>{$job['order_id']}</td>";
                echo "<td>{$job['delivery_status']}</td>";
                echo "<td>{$job['delivery_location']}</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='order_id' value='{$job['order_id']}'>
                            <button type='submit' name='pickup'>Pickup</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
        }
    }
    public function currentDeliveryJobs($userId) {
        // Fetch delivery jobs from the deliveries table
        $stmt = $this->pdo->prepare("SELECT order_id, delivery_status, delivery_location FROM deliveries WHERE deliverer_id = :user_id AND delivery_status = 'delivery'");
        $stmt->execute(['user_id' => $userId]);
        $jobs = $stmt->fetchAll();
    
        if ($jobs) {
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Delivery Status</th><th>Delivery Location</th><th>Action</th></tr>";
    
            foreach ($jobs as $job) {
                echo "<tr>";
                echo "<td>{$job['order_id']}</td>";
                echo "<td>{$job['delivery_status']}</td>";
                echo "<td>{$job['delivery_location']}</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='order_id' value='{$job['order_id']}'>
                            <button type='submit' name='delivered'>Delivered</button>
                        </form>
                      </td>";
                echo "</tr>";
            }
            
            echo "</table>";
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
            //echo "This is the table of your current jobs:";
            $insertStmt = $this->pdo->prepare("INSERT INTO deliveries (deliverer_id, client_id, location, order_id, status) VALUES (:deliverer_id, :client_id, :location, :order_id, 'pickup')");
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
    public function deliveryAnalysis($userId) {
        // Query to count orders grouped by delivery_date in descending order
        $stmt = $this->pdo->prepare("
            SELECT delivery_date, COUNT(order_id) AS order_count
            FROM deliveries
            WHERE deliverer_id = :user_id
            GROUP BY delivery_date
            ORDER BY delivery_date DESC
        ");
        $stmt->execute(['user_id' => $userId]);
        $results = $stmt->fetchAll();
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
