<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>Đây là list products</h2>
               <a href="./index.php?view=add-product" class="btn btn-primary mb-3">Thêm sản phẩm <i class="fas fa-plus"></i></a>
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th>#</th>
                              <th>Tên sản phẩm</th>
                              <th>Hình ảnh</th>
                              <th>Giá</th>
                              <th>Số lượng</th>
                              <th>#id danh mục</th>
                              <th>Thay đổi</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         include_once "../config/DBUntil.php";
                         $db = new DBUntil();
                         $users = $db->select("SELECT * FROM product");
                         foreach ($users as $user) {
                              echo "<tr>";
                              echo "<td>" . $user['id'] . "</td>";
                              echo "<td>" . $user['name'] . "</td>";
                              echo "<td><img src='products/uploads/" . $user['image'] . "' width='50' alt=''></td>";
                              echo "<td>" . $user['price'] . "</td>";
                              echo "<td>" . $user['quantity'] . "</td>";
                              echo "<td>" . $user['category_id'] . "</td>";
                              echo "<td>
                              <a class='btn btn-primary' href='index.php?view=update-product&id=" . $user['id'] . "'>Thay đổi</a>
                              <a class='btn btn-danger' href='index.php?view=delete-product&id=" . $user['id'] . "'>Xóa</a>
                              </td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>