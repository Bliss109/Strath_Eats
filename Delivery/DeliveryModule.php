<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Deliveries</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>

<?php
class DeliveryModule {
    private $pdo;

    // Constructor to initialize PDO connection
    public function __construct($host, $dbname, $username, $password) {
        $dsn = "mysql:host=localhost;dbname=strath_eats;charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        $this->pdo = new PDO($dsn, "root", "", $options);
    }

    // Function to display deliveries with "Add Delivery" buttons

    public function navbar() {
        echo '
        <nav>
            <ul>
                <a href="DeliveryHome.php">Home</a>
                <a href="DeliveryProfile.php">Profile</a>
                <a href="DeliveryWallet.php">Wallet</a>
                <a href="AvailableJobs.php">Available Jobs </a>
                <a href="DeliveryCompleted.php">Completed Jobs </a>
                <a href="#">Order</a>
                <a href="#">Logout</a>
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
            echo "<h3>The available jobs are:</h3>";
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Delivery Location</th><th>Action</th></tr>";

            foreach ($jobs as $job) {
                echo "<tr>";
                echo "<td>{$job['order_id']}</td>";
                echo "<td>{$job['delivery_location']}</td>";
                echo "<td>
                        <form method='POST'>
                            <input type='hidden' name='order_id' value='{$job['order_id']}'>
                            <input type='hidden' name='userID' value='$userId'>
                            <button type='submit' name='take_job'>Take Job</button>
                        </form>
                      </td>";
                echo "</tr>";
            }

            echo "</table>";

            // Handle Take Job button action
            if (/*isset($_POST['take_job']) && */isset($_POST['order_id'])) {
                $orderId = $_POST['order_id'];
                $userId = $_POST['userID'];
                $this->assignJobToDeliverer($orderId, $userId);
            }
        } else {
            echo "<div>No available jobs at the moment.</div>";
        }
    }

    public function assignJobToDeliverer($orderId, $userId) {
        // Update the delivery record to assign deliverer and set status to 'pickup'
        $stmt = $this->pdo->prepare("
            UPDATE deliveries 
            SET deliverer_id = :deliverer_id, delivery_status = 'pickup' 
            WHERE order_id = :order_id AND delivery_status = 'pending'
        ");
        $stmt->execute([
            'deliverer_id' => $userId,
            'order_id' => $orderId
        ]);
    }



    /*public function deliveries() {
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
    }*/
    public function currentPickupJobs($userId) {
        // Fetch current jobs from the deliveries table
        $stmt = $this->pdo->prepare("SELECT order_id, delivery_status, delivery_location FROM deliveries WHERE deliverer_id = :user_id AND delivery_status = 'pickup'");
        $stmt->execute(['user_id' => $userId]);
        $jobs = $stmt->fetchAll();

        if ($jobs) {
            echo "<h3>Your current jobs ready to be picked up are:</h3>";
            echo "<table>";
            echo "<tr><th>Order ID</th><th>Delivery Status</th><th>Delivery Location</th><th>Action</th></tr>";

            foreach ($jobs as $job) {
                echo "<tr>";
                echo "<td>{$job['order_id']}</td>";
                echo "<td>{$job['delivery_status']}</td>";
                echo "<td>{$job['delivery_location']}</td>";
                echo "<td>
                        <form method='POST' >
                            <input type='hidden' name='order_id' value='{$job['order_id']}'>
                            <button type='submit' name='pickup'>Pickup</button>
                        </form>";

                        if(isset($_POST['order_id'])){
                            echo "<form method='POST'>
                                <label>Enter your ID and the order ID for validation</label>
                                <label for='order_id'>Order ID:</label>
                                <input type='text' name='order_id' required>
                                <label for='user_id'>Deliverer ID:</label>
                                <input type='text' name='deliverer_id' required>
                                <button type='submit' name='pick_delivery' value='pick_delivery'>Pick Delivery</button>
                                </form>";
                                if (isset($_POST['pick_delivery'])) {
                                    $orderId = $_POST['order_id'];
                                    $userId = $_POST['deliverer_id'];
                                    $stmt = $this->pdo->prepare("SELECT order_id, deliverer_id FROM deliveries WHERE order_id = $orderId");
                                    $stmt->execute();
                                    $result = $stmt->fetch();
                                    $order_id1 = $result['order_id'];
                                    $deliverer_id = $result['deliverer_id'];
                                    if ($orderId==$order_id1 && $userId==$deliverer_id){
                                        $this->pickDelivery($orderId, $userId);

                                        }
                                }
                        }
                      "</td>";
                echo "</tr>";
            }

            echo "</table>";
        }
        else{
            echo"There are currently no pickup jobs";
        }
    }
    public function currentDeliveryJobs($userId) {
        // Fetch delivery jobs from the deliveries table
        $stmt = $this->pdo->prepare("SELECT order_id, delivery_status, delivery_location FROM deliveries WHERE deliverer_id = :user_id AND delivery_status = 'delivery'");
        $stmt->execute(['user_id' => $userId]);
        $jobs = $stmt->fetchAll();

        if ($jobs) {
            echo "<h3>Your current jobs on delivery jobs are:</h3>";
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
                        </form>";
                        if(isset($_POST['delivered'])){
                            $this->CompleteDeliveryForm();
                        }
                      echo "</td>
                            </tr>";
            }

            echo "</table>";
        }
    }    
    // Function to add a delivery to the pickup table
    public function AddDelivery($orderId) {
        // Update the delivery_status to 'pickup' for the given order_id
        $stmt = $this->pdo->prepare("
            UPDATE deliveries 
            SET delivery_status = 'pickup' 
            WHERE order_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            echo "Order ID $orderId has been set to 'pickup'.";
        } else {
            echo "Failed to update order status. Please check the order ID.";
        }
    }

    // Function to pick a delivery and change status from pickup to delivery
    public function pickDelivery($orderId, $userId) {
        $updateStmt = $this->pdo->prepare("UPDATE deliveries SET delivery_status = 'delivery' WHERE order_id = :order_id AND deliverer_id = :deliverer_id");
            $updateStmt->execute(['order_id' => $orderId, 'deliverer_id' => $userId]);
            echo "Order ID: $orderId status updated to 'delivery'.";

    }

    // Function to complete a delivery, moving the status in orders table to "complete"
    public function completeDelivery($orderId){
        // Update the delivery_status to 'completed' for the given order_id
        $stmt = $this->pdo->prepare("
            UPDATE deliveries 
            SET delivery_status = 'completed' 
            WHERE order_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);

        // Check if any rows were affected
        if ($stmt->rowCount() > 0) {
            echo "Order ID $orderId has been marked as 'completed'.";
        } else {
            echo "Failed to update order status. Please check the order ID.";
        }
    }
    public function Balance($delivererId) {
        // Prepare and execute the SQL statement to fetch the balance
        $stmt = $this->pdo->prepare("SELECT balance FROM users WHERE user_id = :deliverer_id");
        $stmt->execute(['deliverer_id' => $delivererId]);

        // Fetch the balance
        $result = $stmt->fetch();

        if ($result) {
            echo "<div>Balance: ". $result['balance']."</div" ;
        } else {
            echo "Deliverer not found.";
            return null; // or return 0 if you'd like to return a default balance
        }
        
        echo"<form  method='post'>
            <label for='amount'Enter Amount to Withdraw:</label>
            <input type='number' name='amount' min='1' required>
            <button type='submit'>Withdraw</button>
            </form>";
        
        if(isset($_POST['amount'])){
            if($_POST['amount']<= $result['balance']){
                $stmt = $this->pdo->prepare("INSERT INTO withdrawals (user_id, amount) VALUES (:user_id, :amount)");
                $stmt->execute(['user_id' => $deliverer_id, 'amount' => $_POST['amount']]);
            }
        }
        $stmt = $this->pdo->prepare("SELECT withdrawal_id, amount, withdrawal_date, status FROM withdrawals WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $delivererId]);

    // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Display the table
        if ($results) {
            echo "<table border='1'>";
            echo "<tr><th>Withdrawal ID</th><th>Amount</th><th>Withdrawal Date</th><th>Withdrawal Status</th></tr>";

            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>{$row['withdrawal_id']}</td>";
                echo "<td>{$row['amount']}</td>";
                echo "<td>{$row['withdrawal_date']}</td>";
                echo "<td>{$row['status']}</td>";
                echo "</tr>";
            }

            echo "</table>";
        } 
        else {
            echo "No withdrawals found for this user.";
        }
    }
    public function withdraw(){
        
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
 




/*public function PickDeliveryForm(){
        if(isset($_POST['order_id'])){
            echo "<form method='POST' action='$this->pickDeliveryAction()'>
            <label>Enter your ID and the order ID for validation</label>
            <label for='order_id'>Order ID:</label>
            <input type='text' name='order_id' required>
            <label for='user_id'>Deliverer ID:</label>
            <input type='text' name='deliverer_id' required>
            <button type='submit' name='pick_delivery'>Pick Delivery</button>
            </form>";
    }
    
}*/
public function pickDeliveryAction(){
    if (isset($_POST['pick_delivery'])) {
        $orderId = $_POST['order_id'];
        $userId = $_POST['user_id'];
        $stmt = $this->pdo->prepare("SELECT order_id, deliverer_id FROM deliveries WHERE order_id = $orderId");
        $stmt->execute();
        $
        $order_id1 = $result['order_id'];
        $deliverer_id = $result['deliverer_id'];
        if ($orderId==$order_id1 && $userId==$deliverer_id){
            $deliveryModule->pickDelivery($orderId, $userId);
    
            }
    }
}


public function CompleteDeliveryForm(){
    echo"<form method='POST'>
    <label>Enter your ID and the order ID for validation</label>
    <label for='complete_order_id'>Order ID:</label>
    <input type='text' name='complete_order_id' required>
    <label for'userID'>User ID:</label>
    <input type='text' name='user_id' required>
    <button type='submit' name='complete_delivery'>Complete Delivery</button>
    </form>";
    if(isset($_POST['complete_delivery'])){
        $orderId = $_POST['complete_order_id'];
        $userId = $_POST['user_id'];    
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE order_id = $orderId ");
        $stmt->execute();
        $result = $stmt->fetch();
        $user_id_done = $result['user_id'];

        if ($userId==$user_id_done){
            $this->completeDelivery($orderId);
        }
    }
}
public function completeDeliveryAction(){
        echo "hello";
        $orderId = $_POST['complete_order_id'];
        $userId = $_POST['user_id'];    
        $stmt = $this->pdo->prepare("SELECT user_id FROM users WHERE order_id = $orderId ");
        $stmt->execute();
        $result = $stmt->fetch();
        $user_id_done = $result['user_id'];

        if ($userId==$user_id_done){
            $this->completeDelivery($orderId);
        }
    }
    public function completedDeliveries($userId) {
        // Prepare and execute the query
        $stmt = $this->pdo->prepare("
            SELECT order_id, delivery_location, delivery_date, delivery_status 
            FROM deliveries 
            WHERE deliverer_id = :user_id AND delivery_status = 'completed'
        ");
        $stmt->execute(['user_id' => $userId]);
    
        // Fetch all results
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Display results in an HTML table
        if ($results) {
            echo "<table border='1'>";
            echo "<tr><th>Order ID</th><th>Delivery Location</th><th>Delivery Date</th></tr>";
            
            foreach ($results as $row) {
                echo "<tr>";
                echo "<td>{$row['order_id']}</td>";
                echo "<td>{$row['delivery_location']}</td>";
                echo "<td>{$row['delivery_date']}</td>";
                echo "<td>{$row['delivery_status']}</td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "No completed deliveries found for this user.";
        }
    }
}









?>
</body>
</html>