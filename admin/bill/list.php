<?php
// session_start();
include_once "../config/DBUntil.php";

$db = new DBUntil();
?>

<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>Quản lý hóa đơn</h2>
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th class='text-center'>#</th>
                              <th class='text-center'>Họ tên</th>
                              <th class='text-center'>Email</th>
                              <th class='text-center'>Số điện thoại</th>
                              <th class='text-center'>Địa chỉ</th>
                              <th class='text-center'>Mã đơn hàng</th>
                              <th class='text-center'>Tên sản phẩm</th>
                              <th class='text-center'>Số tiền</th>
                              <th class='text-center'>Trạng thái</th>
                              <th class='text-center'>Hành động</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         $bill = $db->select("SELECT * FROM bill");
                         foreach ($bill as $value) {
                              echo "<tr>";
                              echo "<td class='text-center'>" . $value['id'] . "</td>";
                              echo "<td class='text-center'>" . $value['fullname'] . "</td>";
                              echo "<td class='text-center'>" . $value['email'] . "</td>";
                              echo "<td class='text-center'>" . $value['phone'] . "</td>";
                              echo "<td class='text-center'>" . $value['address'] . "</td>";
                              echo "<td class='text-center'>" . $value['id_order'] . "</td>";
                              echo "<td class='text-center'>" . $value['product_name'] . "</td>";
                              echo "<td class='text-center'>$" . $value['total'] . "</td>";
                              if ($value['status'] == 'thành công') {
                                   echo "<td class='text-center'><span class='badge text-bg-success'>Đơn hàng thành công <i class='fas fa-check'></i></span></td>";
                              } elseif ($value['status'] == 'chưa thanh toán') {
                                   echo "<td class='text-center'><span class='badge text-bg-warning'>Chờ thanh toán <i class='fas fa-hourglass-half'></i></span></td>";
                              } else {
                                   echo "<td class='text-center'><span class='badge text-bg-danger'>Đơn hàng thất bại <i class='fas fa-times'></i></span></td>";
                              }
                              echo "<td>
                              <a class='btn btn-danger btn-sm' href='index.php?view=delete-bill&id=" . $value['id'] . "&id_order=" . $value['id_order'] . "'><i class='bi bi-trash'></i></a>
                              <form action='index.php?view=update-bill' method='post' style='display:inline;'>
                                   <input type='hidden' name='order_id' value='" . $value['id_order'] . "'>
                                   <select name='status' class='form-select form-select-sm mt-3'>
                                        <option value='thành công'>Thành công</option>
                                        <option value='chưa thanh toán'>Chưa thanh toán</option>
                                        <option value='thất bại'>Thất bại</option>
                                   </select>
                                   <button type='submit' name='update_status' class='btn btn-success btn-sm mt-3'><i class='bi bi-pencil-square'></i></button>
                              </form>
                              </td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>