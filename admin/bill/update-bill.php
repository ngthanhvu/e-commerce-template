<?php
include_once "../config/DBUntil.php";

$db = new DBUntil();

if (isset($_POST['update_status'])) {
    $orderId = $_POST['order_id'];
    $newStatus = $_POST['status'];

    // Cập nhật trạng thái trong bảng orders
    $updateOrderStatus = $db->update("orders", ['status' => $newStatus], "id = $orderId");

    // Cập nhật trạng thái trong bảng bill
    if ($updateOrderStatus) {
        $updateBillStatus = $db->update("bill", ['status' => $newStatus], "id_order = $orderId");

        if ($updateBillStatus) {
            echo "Trạng thái đơn hàng đã được cập nhật thành công.";
            header("Location: index.php?view=bill");
        } else {
            echo "Lỗi khi cập nhật trạng thái trong bảng bill.";
        }
    } else {
        echo "Lỗi khi cập nhật trạng thái trong bảng orders.";
    }
}
?>
