<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>List Orders Detail</h2>
               <!-- <a href="./index.php?view=add-product" class="btn btn-primary mb-3">Thêm sản phẩm <i class="fas fa-plus"></i></a> -->
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th>#</th>
                              <th># Order</th>
                              <th># Sản phẩm</th>
                              <th>Số lượng</th>
                              <th>Giá tiền</th>
                              <th>Ngày tạo</th>
                              <th>Ngày cập nhật</th>
                              <th>Thay đổi</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         include_once "../config/DBUntil.php";
                         $db = new DBUntil();
                         $perpage = 9;
                         $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                         $start = ($page - 1) * $perpage;

                         $order = $db->select("SELECT * FROM order_details ORDER BY id DESC LIMIT $start, $perpage");
                         $totalOrderDetail = $db->count("order_details");
                         $totalPages = ceil($totalOrderDetail / $perpage);

                         foreach ($order as $orders) {
                              echo "<tr>";
                              echo "<td>" . $orders['id'] . "</td>";
                              echo "<td>" . $orders['order_id'] . "</td>";
                              echo "<td>" . $orders['product_id'] . "</td>";
                              echo "<td>" . $orders['quantity'] . "</td>";
                              echo "<td>" . $orders['price'] . "</td>";
                              echo "<td>" . $orders['created_at'] . "</td>";
                              echo "<td>" . $orders['updated_at'] . "</td>";
                              echo "<td><a href='./index.php?view=delete-order-detail&id=" . $orders['id'] . "' class='btn btn-danger'><i class='bi bi-trash'></i></a></td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>
<nav aria-label="Page navigation">
     <ul class="pagination" style="margin-left: 20px;">
          <?php if ($page > 1) { ?>
               <li class="page-item"><a class="page-link" href="index.php?view=orders-detail&page=<?php echo $page - 1; ?>">Previous</a></li>
          <?php } ?>

          <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
               <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="index.php?view=orders-detail&page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
          <?php } ?>

          <?php if ($page < $totalPages) { ?>
               <li class="page-item"><a class="page-link" href="index.php?view=orders-detail&page=<?php echo $page + 1; ?>">Next</a></li>
          <?php } ?>
     </ul>
</nav>
