<?php
include_once "../config/DBUntil.php";
$token = "";
session_start();

if (isset($_GET['token'])) {
     $token = $_GET['token'];
     $_SESSION['token'] = $token;
     var_dump($token);
     $db = new DBUntil();
     $result = $db->select("SELECT * FROM user WHERE reset_token = '$token' AND reset_token_expires > NOW()");
     if (!$result) {
          echo "Token không hợp lệ hoặc đã hết hạn.";
          exit;
     }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
          $password = $_POST['password'];
          $confirm_password = $_POST['confirm_password'];
          $token = $_SESSION['token'];
          if ($password === $confirm_password) {
               $hashed_password = password_hash($password, PASSWORD_DEFAULT);
               $db = new DBUntil();
               $result = $db->update("user", ["password" => $hashed_password, "reset_token" => null, "reset_token_expires" => null], "reset_token = '$token'");
               if ($result) {
                    echo "Mật khẩu đã được cập nhật thành công.";
                    header("Location: login.php");
                    exit;
               } else {
                    echo "Đã xảy ra lỗi trong quá trình cập nhật mật khẩu.";
               }
          } else {
               echo "Mật khẩu và xác nhận mật khẩu phải trùng nhau!";
          }
     }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Đặt lại mật khẩu</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>

<body>
     <div class="container">
          <h2>Đặt lại mật khẩu</h2>
          <form action="reset-password.php" method="post">
               <div class="mb-3">
                    <label for="password">Mật khẩu mới:</label>
                    <input class="form-control" type="password" id="password" name="password" placeholder="Nhập mật khẩu mới">
               </div>
               <div class="mb-3">
                    <label for="confirm_password">Xác nhận mật khẩu mới:</label>
                    <input class="form-control" type="password" id="confirm_password" name="confirm_password" placeholder="Xac nhận mật khẩu mới">
               </div>
               <button class="btn btn-primary" type="submit">Đặt lại mật khẩu</button>
          </form>
     </div>
</body>

</html>