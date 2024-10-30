<?php
class Cart{
    private $items;
    private $db;

    public function __construct($db){
        if(!isset($_SESSION['cart'])){
            $_SESSION['cart'] = [];
            }
            $this->items = &$_SESSION['cart'];
            $this->db = $db;
        }

        public function addItem($productId, $quantity){
            $stmt = $this->db->prepare("SELECT p.product_id, p.name, p.price, s.quantity as stock_quantity
            FROM products p
            LEFT JOIN stock s ON p.product_id = s.product_id
            WHERE p.product_id = :product_id");
            $stmt->execute([$productId]);
            $product = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$product){
                throw new Exception("Product not Found");
            }
            
            if($product['stock_quantity'] < $quantity){
                throw new Exception("Not enough stock available");
            }

            if(isset($this->items[$productId])){
                $newQuantity = $this->items[$productId]['quantity'] +$quantity;
                if($newQuantity > $product['stock_quantity']){
                    throw new Exception("Cannot add more items than available in stock");
            }
            $this->items[$productId]['quantity'] = $newQuantity;
        }else{
            $this->items[$productId] = [
                'product_id' => $product['product_id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'quantity' => $quantity
            ];
        }
    }

    public function createOrder($userId){
        if(empty($this->items)){
            throw new Exception("Cart is empty");
        }
        try {
            $this->db->beginTransaction();

            $totalAmount = $this->getTotal();
            $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, total_amount, payment_status)
            VALUES (?, ?, 'pending')");

            $stmt->execute([$userId, $totalAmount]);
            $orderId = $this->db->lastInsertId();

            $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUEES(?, ?, ?)");

            $updateStock = $this->db->prepare("
            UPDATE stock
            SET quantity = quantity - ?
            WHERE product_id = ?");

            foreach($this->items as $productId => $item){
                $stmt->execute([
                    $orderId,
                    $productId,
                    $item['quantity'],
                    $item['price']
                ]);

                $updateStock->execute([
                    $item['quantity'],
                    $productId
                ]);
            }

            $this->db->commit();
            $this->clear();
            return $orderId;

        }catch(Exception $e){
            $this->db->rollBack();
            throw $e;
        }
    }

    public function removeItem($productId){
        unset($this->items[$productId]);
    }

    public function updateQuantity($productId, $quantity){
        if($quantity <= 0){
            $this->removeItem($productId);
            return;
        }

        $stmt = $this->db->prepare("
        SELECT quantity as stock_quantity
        FROM stock
        WHERE product_id = ?");

        $stmt->execute([$productId]);
        $stock = $stmt->fetch(PDO::FETCH_ASSOC);

        if($stock && $quantity <= $stock['stock_quantity']){
            $this->items[$productId]['quantity'] = $quantity;
        }else{
            throw new Exception("Not enough stock available");
        }
    }

    public function getTotal(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    public function getItems(){
        return $this->items;
    }

    public function clear(){
        $this->items = [];
        $_SESSION['cart'] = [];
    }

    public function getItemCount() {
        return isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0;
    }
}
?>