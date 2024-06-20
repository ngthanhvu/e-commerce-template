<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
include_once "config/DBUntil.php";

if (isset($_GET['id'])) {
     $id = $_GET['id'];
} else {
     $id = '';
}
$db = new DBUntil();
$user = $db->select("SELECT * FROM user WHERE id = ?", [$id]);
// echo "<pre>";
// var_dump($user);
// echo "</pre>";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (!isset($_POST['username']) && empty($_POST['username'])) {
          $errors['username'] = "Username is required";
     } else {
          $username = $_POST['username'];
     }

     if (!isset($_POST['email']) && empty($_POST['email'])) {
          $errors['email'] = "Email is required";
     } else {
          $email = $_POST['email'];
     }

     if (!isset($_POST['fullname']) && empty($_POST['fullname'])) {
          $errors['fullname'] = "Fullname is required";
     } else {
          $fullname = $_POST['fullname'];
     }

     if (!isset($_POST['phone']) && empty($_POST['phone'])) {
          $errors['phone'] = "Phone is required";
     } else {
          $phone = $_POST['phone'];
     }

     if (!isset($_POST['address']) && empty($_POST['address'])) {
          $errors['address'] = "Address is required";
     } else {
          $address = $_POST['address'];
     }
     // var_dump($_POST);
     // var_dump($id);

     if (count($errors) == 0) {
          global $db;
          $updateUser = $db->update("user", array(
               "username" => $username,
               "email" => $email,
               "fullname" => $fullname,
               "phone" => $phone,
               "address" => $address
          ), "id = $id");
          if ($updateUser) {
               echo "<script type='text/javascript'>
               swal.fire({
                    icon: 'success',
                    title: 'Update success',
                    text: 'Update user successfully',
               }).then(() => {
                    window.location.href = 'profile.php?id=$id';
               });
               </script>";
          } else {
               echo "
               <script type='text/javascript'>
               swal.fire({
                    icon: 'error',
                    title: 'Update failed',
                    text: 'Update user failed',
               });
               </script>
               ";
          }
     }
}
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>';

?>

<div class="container mt-5">
     <div class="row justify-content-center">
          <div class="col-md-6">
               <div class="card">
                    <div class="card-header text-center">
                         <h4>Thông tin người dùng</h4>
                    </div>
                    <div class="card-body">
                         <form action="profile.php?id=<?= $id ?>" method="post">
                              <div class="mb-3">
                                   <label for="username" class="form-label">Username</label>
                                   <input type="text" name="username" class="form-control" id="username" value="<?php echo $user[0]['username']; ?>">
                              </div>
                              <div class="mb-3">
                                   <label for="email" class="form-label">Địa chỉ Email</label>
                                   <input type="text" name="email" class="form-control" id="email" value="<?php echo $user[0]['email']; ?>">
                              </div>
                              <div class="mb-3">
                                   <label for="fullname" class="form-label">Họ và tên</label>
                                   <input type="text" name="fullname" class="form-control" value="<?php echo $user[0]['fullname']; ?>" id="fullname" placeholder="Enter your full name">
                              </div>
                              <div class="mb-3">
                                   <label for="phone" class="form-label">Số điện thoại</label>
                                   <input type="tel" name="phone" class="form-control" id="phone" value="<?php echo $user[0]['phone']; ?>">
                              </div>
                              <div class="mb-3">
                                   <label for="address" class="form-label">Đia chỉ</label>
                                   <input type="text" name="address" class="form-control" id="address" value="<?php echo $user[0]['address']; ?>" placeholder="Enter your address">
                              </div>
                              <button type="submit" class="btn btn-primary w-100">Lưu lại</button>
                         </form>
                    </div>
               </div>
          </div>
     </div>
</div>