<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
include_once "./config/DBUntil.php";

if (isset($_GET['cancel_id'])) {
  $db = new DBUntil();
  $id = $_GET['cancel_id'];
  if (!empty($id)) {
    $updateStatus = $db->update("orders", ['status' => 'hủy'], "id = $id");
    if ($updateStatus) {
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo "
      <script type='text/javascript'>
      Swal.fire({
        icon: 'success',
        title: 'Thành công',
        text: 'Bạn đã hủy đơn hàng thành công',
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'history.php';
        }
      })
      </script>
      ";
      exit();
    }
  }
} else {
  $id = '';
}
// var_dump($id);

?>
<div class="container">
  <h2 class="text-center mt-3 mb-3">Lịch sử đơn hàng</h2>
  <table class="table table-bordered">
    <thead>
      <tr class="bg-primary text-white">
        <th>#</th>
        <th>Họ tên</th>
        <th>Email</th>
        <th>Số điện thoại</th>
        <th>Địa chỉ</th>
        <th>Mã đơn hàng</th>
        <th>Tên sản phẩm</th>
        <th>Số tiền</th>
        <th>Trạng thái</th>
        <th>Thao tác</th>
      </tr>
    </thead>
    <tbody>
      <?php
      include_once "./config/DBUntil.php";
      $db = new DBUntil();

      $query = "
        SELECT orders.id AS order_id, orders.status, orders.total, orders.created_at, orders.updated_at, 
               user.fullname, user.email, user.phone, user.address, 
               order_details.product_id, order_details.quantity, order_details.price, 
               product.name AS product_name
        FROM orders 
        JOIN user ON orders.user_id = user.id
        JOIN order_details ON orders.id = order_details.order_id
        JOIN product ON order_details.product_id = product.id
        WHERE user.id = ?
      ";

      $orders = $db->select($query, [$_SESSION['username']['id']]);

      if ($orders) {
        foreach ($orders as $key => $value) {
          echo "<tr>";
          echo "<td>" . ($key + 1) . "</td>";
          echo "<td>" . $value['fullname'] . "</td>";
          echo "<td>" . $value['email'] . "</td>";
          echo "<td>" . $value['phone'] . "</td>";
          echo "<td>" . $value['address'] . "</td>";
          echo "<td>" . $value['order_id'] . "</td>";
          echo "<td>" . $value['product_name'] . "</td>";
          echo "<td>$" . $value['total'] . "</td>";

          if ($value['status'] == 'thành công') {
            echo "<td><span class='badge text-bg-success'>Đơn hàng thành công <i class='fas fa-check'></i></span></td>";
          } elseif ($value['status'] == 'chưa thanh toán') {
            echo "<td><span class='badge text-bg-warning'>Chờ thanh toán <i class='fas fa-hourglass-half'></i></span></td>";
          } else {
            echo "<td><span class='badge text-bg-danger'>Đơn hàng thất bại <i class='fas fa-times'></i></span></td>";
          }

          echo "<td><a href='history.php?cancel_id=" . $value['order_id'] . "' class='btn btn-danger'>Hủy</a></td>";
          echo "</tr>";
        }
        // Add bill outside the loop
        // $billdata = array(
        //   'fullname' => $value['fullname'],
        //   'email' => $value['email'],
        //   'phone' => $value['phone'],
        //   'address' => $value['address'],
        //   'id_order' => $value['order_id'],
        //   'product_name' => $value['product_name'],
        //   'total' => $value['total'],
        //   'status' => $value['status']
        // );
        // $db->insert('bill', $billdata);


        $existingBill = $db->select("SELECT * FROM bill WHERE id_order = ?", [$value['order_id']]);
        if (!$existingBill) {
          $billdata = array(
            'fullname' => $value['fullname'],
            'email' => $value['email'],
            'phone' => $value['phone'],
            'address' => $value['address'],
            'id_order' => $value['order_id'],
            'product_name' => $value['product_name'],
            'total' => $value['total'],
            'status' => $value['status']
          );
          $db->insert('bill', $billdata);
        }
      } else {
        echo "<tr><td colspan='10' class='text-center'>Không có đơn hàng nào</td></tr>";
      }
      echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>';
      ?>
    </tbody>
  </table>
</div>