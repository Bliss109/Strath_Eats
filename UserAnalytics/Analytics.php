<?php
require_once '../dbConn/Connection.php';

class Analytics {
    private $db;

    public function __construct(){
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getUserStats(){
        $sql = "SELECT role , COUNT(*) as total_users
        COUNT(CASE WHEN last_loogin >= NOW() - INTERVAL 7 DAY THEN 1 END) as active_users
        FROM users
        GROUP BY role ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderStats(){
        $sql = "SELECT DATE(order_date) as date,
        COUNT(*) as total_orders,
        SUM(total_amount) as daily_revenue
        FROM orders
        GROUP BY DATE(order_date)
        ORDER BY date DESC
        LIMIT 30";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPopularItems(){
        $sql = "SELECT p.name,
        COUNT(*) as order_count
        FROM order_items oi
        JOIN products p ON p.product_id = oi.product_id
        GROUP BY p.product_id
        ORDER BY order_count DESC
        LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}