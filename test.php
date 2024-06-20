<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
session_start();
$post = '';
$id = '';



if (isset($_POST['cart']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $post = $_POST['cart'][$id];
}

echo "<pre>";
var_dump($post['cart_id']);
echo "</pre>";


include_once "config/DBUntil.php";
include_once "cart-services.php";

$db = new DBUntil();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_SESSION['username']['id'];
    var_dump($post);
    $orderData = [
        'user_id' => $userId,
        'total' => $post['total'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ];

    try {
        $orderId = $db->insert('orders', $orderData);

        foreach ($_POST['cart'] as $productId => $cartItem) {
            $orderDetail = [
                'order_id' => $orderId,
                'product_id' => $productId,
                'quantity' => $cartItem['quantity'],
                'price' => $cartItem['price'],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];
            $db->insert('order_details', $orderDetail);
        }

        $_SESSION['cart'] = [];
        // $db->delete('cart', 'id= ' . $post['cart_id']);
    } catch (PDOException $ex) {
        echo $ex->getMessage();
    }
    // echo "<script>alert('Thanh toan thanh cong!')</script>";
    header("Location: checkout.php?id=" . $orderId);
    exit();

    // echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
    // echo "<script>
    //     Swal.fire({
    //         title: 'Order success!',
    //         icon: 'success',
    //         text: 'Order successfully!',
    //     }).then((result) => {
    //         if (result.isConfirmed) {
    //             window.location.href = 'checkout.php?id=" . $orderId . "';
    //         }
    //     });
    // </script>";
    // exit();
}
