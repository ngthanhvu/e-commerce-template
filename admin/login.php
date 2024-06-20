<?php
include_once "./include/header.php";
include_once '../config/DBUntil.php';
session_start();
$errors = [];
$db = new DBUntil();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && empty($_POST['username'])) {
        $errors['username'] = "Please enter username";
    } else {
        $username = $_POST['username'];
    }

    if (isset($_POST['password']) && empty($_POST['password'])) {
        $errors['password'] = "Please enter password";
    } else {
        $password = $_POST['password'];
    }

    if (count($errors) == 0) {
        $result = $db->select("SELECT * FROM user WHERE username = '$username'");
        if (count($result) > 0) {
            if (password_verify($password, $result[0]['password'])) {
                $_SESSION['username'] = $result[0];
                echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Login successfully',
                }).then(() => {
                    window.location.href = '../index.php';
                })
                </script>";
                exit();
            } else {
                $errors['login'] = "Invalid username or password";
            }
        }
    }
}

?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5" style="margin-top: 30px;">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <form action="login.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputEmail" name="username" type="text" placeholder="name@example.com" />
                                            <label for="inputEmail">Username</label>
                                            <?php
                                            if (isset($errors['username'])) {
                                                echo "<span class='text-danger'>" . $errors['username'] . "</span>";
                                            }
                                            ?>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" />
                                            <label for="inputPassword">Password</label>
                                            <?php
                                            if (isset($errors['password'])) {
                                                echo "<span class='text-danger'>" . $errors['password'] . "</span>";
                                            }
                                            if (isset($errors['login'])) {
                                                echo "<script>
                                                Swal.fire({
                                                    icon: 'error',
                                                    title: 'Error',
                                                    text: '" . $errors['login'] . "',
                                                });
                                                    </script>";
                                            }
                                            ?>
                                        </div>
                                        <div class="form-check mb-3">
                                            <input class="form-check-input" id="inputRememberPassword" type="checkbox" value="" />
                                            <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="forgot-password.php">Forgot Password?</a>
                                            <button type="submit" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.php">Need an account? Sign up!</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>