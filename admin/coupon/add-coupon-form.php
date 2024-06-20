<?php
include_once "../config/DBUntil.php";
$db = new DBUntil();
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['code']) && empty($_POST['code'])) {
        $errors['code'] = "code is required";
    } else {
        $code = $_POST['code'];
    }
    if (isset($_POST['phan_tram_giam']) && empty($_POST['phan_tram_giam'])) {
        $errors['phan_tram_giam'] = "phan_tram_giam is required";
    } else {
        $phan_tram_giam = $_POST['phan_tram_giam'];
    }
    if (isset($_POST['so_tien_giam']) && empty($_POST['so_tien_giam'])) {
        $errors['so_tien_giam'] = "so_tien_giam is required";
    } else {
        $so_tien_giam = $_POST['so_tien_giam'];
    }
    if (isset($_POST['ngay_het_han']) && empty($_POST['ngay_het_han'])) {
        $errors['ngay_het_han'] = "ngay_het_han is required";
    } else {
        $ngay_het_han = $_POST['ngay_het_han'];
    }

    if (count($errors) == 0) {
        global $db;
        // var_dump($_POST);
        $coupon = $db->insert("coupons", [
            "code" => $code,
            "phan_tram_giam" => $phan_tram_giam,
            "so_tien_giam" => $so_tien_giam,
            "ngay_het_han" => $ngay_het_han,
            "con_hieu_luc" => 1
        ]);
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        if ($coupon) {
            echo "<script type='text/javascript'>
            Swal.fire({
                icon: 'success',
                title: 'Add success',
                text: 'Add coupon successfully',
            });
            </script>";
        } else {
            echo "<script type='text/javascript'>
            Swal.fire({
                icon: 'error',
                title: 'Add failed',
                text: 'Failed to add coupon.',
            });
            </script>";
        }
    }
}

?>

<div class="container">
    <form action="index.php?view=add-coupon" method="post">
        <h2 class="mt-3">Add coupon</h2>
        <div class="mb-3 mt-3">
            <label for="name" class="form-label">Code:</label>
            <input type="text" class="form-control" id="code" placeholder="Enter code" name="code">
            <?php if (isset($errors['code'])) {
                echo "<p class='text-danger'>" . $errors['code'] . "</p>";
            } ?>
            <label for="name" class="form-label">Phần trăm giảm:</label>
            <input type="text" class="form-control" id="code" placeholder="Enter phần trăm giảm" name="phan_tram_giam">
            <?php if (isset($errors['phan_tram_giam'])) {
                echo "<p class='text-danger'>" . $errors['phan_tram_giam'] . "</p>";
            } ?>
            <label for="name" class="form-label">Số tiền giảm:</label>
            <input type="text" class="form-control" id="code" placeholder="Enter số tiền giảm" value="1" name="so_tien_giam">
            <?php if (isset($errors['so_tien_giam'])) {
                echo "<p class='text-danger'>" . $errors['so_tien_giam'] . "</p>";
            } ?>
            <label for="name" class="form-label">Ngày hết hạn:</label>
            <input type="date" class="form-control" id="code" placeholder="Enter ngày hết hạn" name="ngay_het_han">
            <?php if (isset($errors['ngay_het_han'])) {
                echo "<p class='text-danger'>" . $errors['ngay_het_han'] . "</p>";
            } ?>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>