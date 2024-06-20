<div id="layoutSidenav_content">
     <main>
          <div class="container-fluid px-4">
               <br>
               <h2>Manage User</h2>
               <br>
               <table class="table table-bordered">
                    <thead>
                         <tr class="bg-primary text-white">
                              <th>#</th>
                              <th>Tài khoản người dùng</th>
                              <th>Email</th>
                              <th>Số điện thoại</th>
                              <th>Vai trò</th>
                              <th>Hành động</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php
                         include_once "../config/DBUntil.php";
                         $db = new DBUntil();
                         $users = $db->select("SELECT * FROM user");
                         foreach ($users as $user) {
                              echo "<tr>";
                              echo "<td>" . $user['id'] . "</td>";
                              echo "<td>" . $user['username'] . "</td>";
                              echo "<td>" . $user['email'] . "</td>";
                              echo "<td>" . $user['phone'] . "</td>";
                              echo "<td>" . $user['role'] . "</td>";
                              echo "<td>
                              <a class='btn btn-primary' href='index.php?view=update-user&id=" . $user['id'] . "'><i class='bi bi-pencil-square'></i></a>
                              <a class='btn btn-danger' href='index.php?view=delete-user&id=" . $user['id'] . "'><i class='bi bi-trash'></i></a>
                              </td>";
                              echo "</tr>";
                         }
                         ?>
                    </tbody>
               </table>
          </div>
     </main>
</div>