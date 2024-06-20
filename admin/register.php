<?php
include_once "./include/header.php";
include_once '../config/DBUntil.php';

$errors = [];
$db = new DBUntil();
function isCheckEmail($email)
{

    $db = new DBUntil();
    return $db->select("SELECT * FROM user WHERE email = '$email'");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['username']) && empty($_POST['username'])) {
        $errors['username'] = "Please enter username";
    } else {
        $username = $_POST['username'];
    }

    if (isset($_POST['email']) && empty($_POST['email'])) {
        $errors['email'] = "Please enter email";
    } else {
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email format";
        } else {
            if (isCheckEmail($_POST['email'])) {
                $errors['email'] = "Email already exists";
            }
            $email = $_POST['email'];
        }
    }

    if (isset($_POST['password']) && empty($_POST['password'])) {
        $errors['password'] = "Please enter password";
    } else {
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }

    if (isset($_POST['phone']) && empty($_POST['phone'])) {
        $errors['phone'] = "Please enter phone";
    } else {
        if (!preg_match('/^\d{10}$/', $_POST['phone'])) {
            $errors['phone'] = "Invalid phone format";
        }
        $phone = $_POST['phone'];
    }

    if (isset($_POST['confimpassword']) && empty($_POST['confimpassword'])) {
        $errors['confimpassword'] = "Please enter confirm password";
    } else {
        if ($_POST['password'] != $_POST['confimpassword']) {
            $errors['confimpassword'] = "Password not match";
        } else {
            $confimpassword = $_POST['confimpassword'];
        }
        $confimpassword = $_POST['confimpassword'];
    }

    if (count($errors) == 0) {
        global $db;
        $user = $db->insert('user', [
            'username' => $username,
            'email' => $email,
            'password' => $hashed_password,
            'phone' => $phone,
            'role' => 'user'
        ]);
        echo "<script type='text/javascript'>
            swal.fire({
                title: 'Success',
                text: 'Register successfully',
                icon: 'success'
            }).then(function() {
                window.location.href = 'login.php';
            });
        </script>";
        exit();
    }
}


?>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7" style="margin-top: 5px;">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                                </div>
                                <div class="card-body">
                                    <form action="register.php" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="username" id="" type="text" placeholder="Your Username" />
                                            <label for="inputEmail">Username</label>
                                            <?php
                                            if (isset($errors['username'])) {
                                                echo "<span class='text-danger'>" . $errors['username'] . "</span>";
                                            }
                                            ?>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="email" id="inputEmail" type="text" placeholder="name@example.com" />
                                            <label for="inputEmail">Email address</label>
                                            <?php
                                            if (isset($errors['email'])) {
                                                echo "<span class='text-danger'>" . $errors['email'] . "</span>";
                                            }
                                            ?>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" name="phone" id="" type="text" placeholder="+098 876 343" />
                                            <label for="inputEmail">Phone</label>
                                            <?php
                                            if (isset($errors['phone'])) {
                                                echo "<span class='text-danger'>" . $errors['phone'] . "</span>";
                                            }
                                            ?>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="password" id="inputPassword" type="password" placeholder="Create a password" />
                                                    <label for="inputPassword">Password</label>
                                                    <?php
                                                    if (isset($errors['password'])) {
                                                        echo "<span class='text-danger'>" . $errors['password'] . "</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating mb-3 mb-md-0">
                                                    <input class="form-control" name="confimpassword" id="inputPasswordConfirm" type="password" placeholder="Confirm password" />
                                                    <label for="inputPasswordConfirm">Confirm Password</label>
                                                    <?php
                                                    if (isset($errors['confimpassword'])) {
                                                        echo "<span class='text-danger'>" . $errors['confimpassword'] . "</span>";
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-0">
                                            <div class="d-grid"><button type="submit" class="btn btn-primary btn-block">Create Account</button></div>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.php">Have an account? Go to login</a></div>
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