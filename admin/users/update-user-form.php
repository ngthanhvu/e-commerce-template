<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];

if (isset($_GET['id'])) {
     $id = $_GET['id'];
} else {
     $id = '';
}
if ($id) {
     $result = $db->select("SELECT * FROM user WHERE id = $id");
     if ($result && count($result) > 0) {
          $user = $result[0];
          $oldrole = $user['role'];
     } else {
          echo "User not found";
          exit;
     }
} else {
     echo "User ID is missing";
     exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     if (empty($_POST['username'])) {
          $errors['username'] = "Username is required";
     } else {
          $username = $_POST['username'];
     }

     if (empty($_POST['email'])) {
          $errors['email'] = "Email is required";
     } else {
          $email = $_POST['email'];
     }

     if (empty($_POST['phone'])) {
          $errors['phone'] = "Phone is required";
     } else {
          $phone = $_POST['phone'];
     }

     if (empty($_POST['role'])) {
          $errors['role'] = "Role is required";
     } else {
          $role = $_POST['role'];
     }

     if (count($errors) == 0) {
          $updated = $db->update("user", [
               "username" => $username,
               "email" => $email,
               "phone" => $phone,
               "role" => $role
          ], "id = $id");

          if ($updated) {
               echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Update success',
                text: 'Update user successfully',
            });
            </script>";
          } else {
               echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Update failed',
                text: 'Failed to update user.',
            });
            </script>";
          }
     }
}
?>

<div class="container">
     <form action="index.php?view=update-user&id=<?= $id ?>" method="post">
          <h2 class="mt-3">Update User</h2>
          <div class="mb-3 mt-3">
               <label for="name" class="form-label">Username:</label>
               <input type="text" class="form-control" id="name" value="<?php echo $user['username']; ?>" name="username">
               <?php if (isset($errors['username'])) {
                    echo "<p class='text-danger'>" . $errors['username'] . "</p>";
               } ?>
          </div>
          <div class="mb-3">
               <label for="image" class="form-label">Email:</label>
               <input type="text" class="form-control" id="image" value="<?php echo $user['email']; ?>" name="email">
               <?php if (isset($errors['email'])) {
                    echo "<p class='text-danger'>" . $errors['email'] . "</p>";
               } ?>
          </div>
          <div class="mb-3">
               <label for="price" class="form-label">Phone:</label>
               <input type="text" class="form-control" id="price" value="<?php echo $user['phone']; ?>" name="phone">
               <?php if (isset($errors['phone'])) {
                    echo "<p class='text-danger'>" . $errors['phone'] . "</p>";
               } ?>
          </div>
          <div class="mb-3">
               <label for="" class="form-label">Role:</label>
               <select class="form-select" aria-label="Select role" name="role">
                    <option value="admin" <?php if ($oldrole == 1) echo 'selected="selected"'; ?>>Admin</option>
                    <option value="user" <?php if ($oldrole == 0) echo 'selected="selected"'; ?>>User</option>
               </select>
               
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
     </form>
</div>