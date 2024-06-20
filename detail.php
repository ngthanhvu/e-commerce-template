<?php include_once "./includes/header.php"; ?>
<?php include_once "./includes/navbar.php"; ?>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
include_once "config/DBUntil.php";
$db = new DBUntil();

$product = $db->select("SELECT * FROM product WHERE id = ?", [$id]);

$relatedProducts = [];
// $userID = $_SESSION['username']['id'];
if (!empty($_SESSION['username'])) {
    $userID = $_SESSION['username']['id'];
} else {
    $userID = "";
}
if (!empty($product)) {
    $categoryId = $product[0]['category_id'];

    $recommendProduct = $db->select("SELECT * FROM product WHERE category_id = ? AND id != ?", [$categoryId, $id]);
}
?>
<section class="py-5">

    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="./admin/products/uploads/<?php echo $product[0]['image']; ?>" alt="Product Image" /></div>
            <div class="col-md-6">
                <div class="small mb-1"><?php echo $product[0]['id']; ?></div>
                <h1 class="display-5 fw-bolder"><?php echo $product[0]['name']; ?></h1>
                <div class="fs-5 mb-5">
                    <span class="text-decoration-line-through">$45.00</span>
                    <span><?php echo $product[0]['price']; ?>$</span>
                </div>
                <p class="lead"><?php echo $product[0]['description']; ?></p>
                <div class="d-flex">
                    <input class="form-control text-center me-3" id="inputQuantity" type="num" value="1" style="max-width: 3rem" />

                    <a class="btn btn-outline-dark flex-shrink-0" href="cart-handle.php?id=<?php echo $product[0]['id']; ?>&action=add&uid=<?php echo $userID; ?>">
                        <i class="bi-cart-fill me-1"></i>
                        Add to cart
                    </a>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Recommend product</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            if (!empty($recommendProduct)) {
                foreach ($recommendProduct as $relatedProduct) {
            ?>
                    <div class="col mb-5">
                        <a href="detail.php?id=<?php echo $relatedProduct['id']; ?>" style="color: black; text-decoration: none;">
                            <div class="card h-100">
                                <!-- Product image-->
                                <img class="card-img-top" src="./admin/products/uploads/<?php echo $relatedProduct['image']; ?>" alt="Related Product Image" />
                                <!-- Product details-->
                                <div class="card-body p-4">
                                    <div class="text-center">
                                        <!-- Product name-->
                                        <h5 class="fw-bolder"><?php echo $relatedProduct['name']; ?></h5>
                                        <!-- Product price-->
                                        <?php echo $relatedProduct['price']; ?>$
                                    </div>
                                </div>
                                <!-- Product actions-->
                                <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                    <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="product.php?id=<?php echo $relatedProduct['id']; ?>">View options</a></div>
                                </div>
                            </div>
                        </a>
                    </div>
            <?php
                }
            } else {
                echo "<p>Không có sản phẩm nào liên quan.</p>";
            }
            ?>
        </div>
    </div>
</section>
<!-- Footer-->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p>
    </div>
</footer>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="js/scripts.js"></script>
</body>

</html>