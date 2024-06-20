<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
date_default_timezone_set('Asia/Ho_Chi_Minh');

echo "<pre>";
// var_dump($_SESSION);
echo "</pre>";

if (!isset($_SESSION['username'])) {
    session_destroy();
    header("Location: ./admin/login.php");
    exit();
}

if (isset($_POST['payment'])) {
    include_once "vnpay_config.php";
    include_once "config/DBUntil.php";
    $db = new DBUntil();
    $id = $_GET['id'];
    $payment = $_POST['payment'];

    if ($payment == "vnpay") {
        $order_id = $id;
        $amount = $_SESSION['total'];

        $order_desc = "Payment for order #" . $order_id;

        $vnpay_url = PaymentService::createUrlPayment($order_id, $amount);

        header("Location: $vnpay_url");
        exit();
    } else {
        $status = ($payment == "cod") ? "chưa thanh toán" : "thành công";
        $db->update("orders", ['payment' => $payment, 'status' => $status], "id = $id");
        $removes = $db->select("SELECT * FROM cart");
        if (!empty($removes)) {
            foreach ($removes as $remove) {
                $db->delete("cart", "id = " . $remove['id']);
            }
        }
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo "
        <script type='text/javascript'>
        Swal.fire({
            icon: 'success',
            title: 'Thành công',
            text: 'Bạn đã Order thành công',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'history.php';
            }
        })
        </script>
        ";
        exit();
    }
}
?>

<body class="bg-light">
    <div class="container">
        <div class="py-5 text-center">
            <h2>Checkout</h2>
        </div>

        <div class="row">
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <!-- <span class="badge badge-secondary badge-pill">3</span> -->
                </h4>
                <ul class="list-group mb-3">
                    <?php
                    include_once "cart-services.php";
                    global $db;
                    $cart = $db->select("SELECT * FROM cart");
                    $carts = new Cart();
                    $totalCart = $carts->getTotal();

                    foreach ($cart as $carts) {
                    ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $carts['name']; ?></h6>
                                <small class="text-muted">Quantity: <?php echo $carts['quantity']; ?></small>
                            </div>
                            <span class="text-muted">$<?php echo $carts['price']; ?></span>
                        </li>
                    <?php
                    }
                    ?>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (USD)</span>
                        <strong>$<?php echo $_SESSION['beforeTotal'] ?? "0"; ?></strong>
                    </li>
                </ul>
            </div>
            <div class="col-md-8 order-md-1">
                <?php
                include_once "config/DBUntil.php";
                $db = new DBUntil();
                $id = $_GET['id'];
                $usercheckout = $db->select("SELECT * FROM orders WHERE id = $id");
                $users = $usercheckout[0]['user_id'];
                $userCheck = $db->select("SELECT * FROM user WHERE id = $users");

                foreach ($userCheck as $nguoidung) {
                ?>
                    <div class="mb-3">
                        <label for="fullname">Full name</label>
                        <input type="text" class="form-control" id="fullname" value="<?php echo $nguoidung['fullname']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="username">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input type="text" class="form-control" id="username" placeholder="Username" value="<?php echo $nguoidung['username']; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email">Email <span class="text-muted">(Required field)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com" value="<?php echo $nguoidung['email']; ?>">
                    </div>

                    <div class="mb-3">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" value="<?php echo $nguoidung['phone']; ?>" placeholder="1234 Main St">
                    </div>

                    <div class="mb-3">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" value="<?php echo $nguoidung['address']; ?>" placeholder="1234 Main St">
                    </div>
                <?php
                }
                ?>
                <h4 class="mb-3">Billing address</h4>
                <form class="needs-validation" method="post" action="checkout.php?id=<?php echo $id; ?>">
                    <hr class="mb-4">
                    <h4 class="mb-3">Payment</h4>
                    <div class="d-block my-3">
                        <div class="custom-control custom-radio">
                            <input id="credit" name="payment" type="radio" class="custom-control-input" value="cod" checked>
                            <label class="custom-control-label" for="credit">COD</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input id="debit" name="payment" type="radio" class="custom-control-input" value="vnpay">
                            <label class="custom-control-label" for="debit">VNPAY</label>
                        </div>
                    </div>
                    <hr class="mb-4">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm Order</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; 2017-2020 Company Name</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
    <?php
    echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>';
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>
</html>