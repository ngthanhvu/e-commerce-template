<?php
session_start();
include_once "config/DBUntil.php";

$db = new DBUntil();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['cartQty'])) {
        foreach ($_POST['cartQty'] as $productId => $quantity) {
            $data = ['quantity' => $quantity];
            $condition = "product_id = $productId";
            $db->update("cart", $data, $condition);
        }
    }
    header("Location: cart.php");
    exit;
}
?>
