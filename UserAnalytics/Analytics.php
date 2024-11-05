<?php
require_once '../dbConn/Connection.php';

class Analytics {
    private $db;

    public function __construct() {
        $db = new Database();
        $this->db = $db->getConnection();
    }

    public function getUserStats() {
        $sql = "SELECT role, 
                COUNT(*) as total_users 
                FROM users 
                GROUP BY role";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderStats() {
        $sql = "SELECT 
                DATE(order_date) as date,
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

    public function getPopularItems() {
        $sql = "SELECT 
                p.name,
                COUNT(oi.order_item_id) as order_count,
                SUM(oi.quantity) as total_quantity
                FROM products p
                JOIN order_items oi ON p.product_id = oi.product_id
                GROUP BY p.product_id, p.name
                ORDER BY order_count DESC
                LIMIT 10";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getRevenueByDay() {
        try {
            $sql = "SELECT 
                    DATE(order_date) as date,
                    SUM(total_amount) as daily_revenue
                    FROM orders 
                    WHERE order_date >= DATE_SUB(CURRENT_DATE(), INTERVAL 7 DAY)
                    AND payment_status = 'paid'
                    GROUP BY DATE(order_date)
                    ORDER BY date DESC";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error in getRevenueByDay: " . $e->getMessage();
            return [];
        }
    }

    public function getProductCategories() {
        try {
            $sql = "SELECT 
                    category,
                    COUNT(*) as product_count
                    FROM products 
                    GROUP BY category
                    HAVING category IS NOT NULL";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error in getProductCategories: " . $e->getMessage();
            return [];
        }
    }

    public function debugTables() {
        $sql = "SHOW TABLES";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $structure = [];
        foreach ($tables as $table) {
            $sql = "DESCRIBE " . $table;
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $structure[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $structure;
    }

    public function getTotalUsers() {
        try {
            $sql = "SELECT COUNT(*) as total FROM users";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalOrders() {
        try {
            $sql = "SELECT COUNT(*) as total FROM orders";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }

    public function getTotalRevenue() {
        try {
            $sql = "SELECT SUM(total_amount) as total FROM orders WHERE payment_status = 'paid'";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total'] ?? 0;
        } catch (PDOException $e) {
            return 0;
        }
    }
}