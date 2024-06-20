<?php
session_start();
include_once "config/DBUntil.php";
include_once "cart-services.php";

$cart = new Cart();
$db = new DBUntil();

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $action = $_GET['action'];
    $id = $_GET['id'];

    if ($action == 'add') {
        $detail = $db->select("SELECT * FROM product WHERE id = ?", [$id]);
        if (count($detail) > 0) {
            $quantity = 1;
            $cartItem = $db->select("SELECT * FROM cart WHERE product_id = ?", [$id]);
            
            if ($cartItem) {
                $quantity += $cartItem[0]['quantity'];
                // $db->update("cart", ['quantity' => $quantity], "product_id = ?", [$id]);
                $db->update("cart", ['quantity' => $quantity], "product_id = $id");
            } else {
                $data = [
                    'product_id' => $id,
                    'name' => $detail[0]['name'],
                    'price' => $detail[0]['price'],
                    'img' => $detail[0]['image'],
                    'quantity' => $quantity,
                    'user_id' => $_SESSION['username']['id']
                ];
                $db->insert("cart", $data);
            }
            header("location: cart.php");
        }
    } else if ($action == 'remove') {
        $db->delete('cart','product_id='.$id);
        header("location: cart.php");
    }
}

