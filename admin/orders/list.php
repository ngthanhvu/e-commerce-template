<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>List Orderss</h2>
               <!-- <a href="./index.php?view=add-product" class="btn btn-primary mb-3">Thêm sản phẩm <i class="fas fa-plus"></i></a> -->
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th>#</th>
                              <th># người dùng</th>
                              <th>Tên người dùng</th>
                              <th>Tổng cộng</th>
                              <th>Ngày tạo</th>
                              <th>Ngày cập nhật</th>
                              <th>Thay đổi</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         include_once "../config/DBUntil.php";
                         $db = new DBUntil();
                         $order = $db->select("SELECT * FROM orders");

                         foreach ($order as $orders) {
                              echo "<tr>";
                              echo "<td>" . $orders['id'] . "</td>";
                              echo "<td>" . $orders['user_id'] . "</td>";
                              $idUser = $orders['user_id'];
                              $user = $db->select("SELECT * FROM user WHERE id = ?", [$idUser]);

                              if (!empty($user)) {
                                   echo "<td>" . $user[0]['username'] . "</td>";
                              } else {
                                   echo "<td></td>";
                              }
                              echo "<td>" . $orders['total'] . "</td>";
                              echo "<td>" . $orders['created_at'] . "</td>";
                              echo "<td>" . $orders['updated_at'] . "</td>";
                              echo "<td>
                              <a class='btn btn-danger' href='index.php?view=delete-order&id=" . $orders['id'] . "'><i class='bi bi-trash'></i></a>
                              </td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>