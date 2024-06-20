<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>Đây là list cateogory</h2>
               <a href="./index.php?view=add-category" class="btn btn-primary mb-3">Thêm category <i class="fas fa-plus"></i></a>
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th>#</th>
                              <th>Tên danh mục</th>
                              <th>Thay đổi</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         include_once "../config/DBUntil.php";
                         $db = new DBUntil();
                         $users = $db->select("SELECT * FROM category");
                         foreach ($users as $user) {
                              echo "<tr>";
                              echo "<td>" . $user['id'] . "</td>";
                              echo "<td>" . $user['name'] . "</td>";
                              echo "<td>
                              <a class='btn btn-primary' href='index.php?view=update-category&id=" . $user['id'] . "'><i class='bi bi-pencil-square'></i></a>
                              <a class='btn btn-danger' href='index.php?view=delete-category&id=" . $user['id'] . "'><i class='bi bi-trash'></i></a>
                              </td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>