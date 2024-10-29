<?php
session_start();
require_once '../dbConn/Connection.php';
require_once 'Cart.php';

$database = new Database();
$db = $database->getConnection();
$cart = new Cart($db);

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $action = $data['action'] ?? '';

    try{
        switch($action){
            case 'add':
                $cart->addItem(
                    $data['product_id'],
                    $data['quantity'] ?? 1
                );
                $response = ['success' => true, 'message' => true];
                break;


            case 'remove':
                $cart->removeItem($data['product_id']);
                $response = ['success' => true, 'message' => 'Item removed from cart'];
                break;
                
            case 'update':
                $cart->updateQuantity(
                    $data['product_id'],
                    $data['quantity']
                );
                $response = ['success' => true, 'message' => 'Cart updated'];
                break;

            case 'checkout':
                if(isset($_SESSION['user_id'])){
                    throw new Exception("User not logged in");
                }
                $orderId = $cart->createOrder($_SESSION['user_id']);
                $response = ['success' => true, 'message' => 'Checkout successful', 'order_id' => $orderId];
                break;

                case 'get':
                    $response = [
                        'success' => true,
                        'items' => $cart->getItems(),
                        'total' => $cart->getTotal()
                    ];
                    break;

                    default:
                    throw new Exception ('Invalid action!');
        }
    }catch(Exception $e){
        $response = ['success' => false, 'message' => $e->getMessage()];
    }

}

header('Content-Type: application/json');
echo json_encode($response);
