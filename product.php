<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
include_once "config/DBUntil.php";

$db = new DBUntil();
$search = isset($_GET['search']) ? $_GET['search'] : '';
$category_id = isset($_GET['category']) ? $_GET['category'] : '';

$perPage = 8; 
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$start = ($page - 1) * $perPage;

$query = "SELECT * FROM product WHERE (name LIKE ? OR price LIKE ?)";
$params = ["%$search%", "%$search%"];

if (!empty($category_id)) {
    $query .= " AND category_id = ?";
    $params[] = $category_id;
}

$query .= " LIMIT $start, $perPage";

$product = $db->select($query, $params);

$totalUsers = $db->count("product", "1");
$totalPages = ceil($totalUsers / $perPage);
?>



<section class="py-5">
    <div class="container">
        <!-- Form lọc sản phẩm -->
        <div class="row mb-3">
            <div class="col-md-12">
                <form action="product.php" method="GET" class="d-flex">
                    <input type="text" class="form-control me-2" name="search" value="<?php echo $search; ?>" placeholder="Search products">
                    <select name="category" class="form-select me-2">
                        <option value="">Chọn danh mục</option>
                        <?php
                        // Lấy danh sách các danh mục
                        $categories = $db->select("SELECT id, name FROM category");
                        foreach ($categories as $category) {
                            $selected = ($category['id'] == $category_id) ? 'selected' : '';
                            echo '<option value="' . $category['id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                        }
                        ?>
                    </select>
                    <button type="submit" class="btn btn-outline-success">Lọc</button>
                </form>
            </div>
        </div>
        <!-- Hiển thị danh sách sản phẩm -->
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">
            <?php
            foreach ($product as $products) {
            ?>
                <div class="col mb-5">
                    <a href="detail.php?id=<?php echo $products['id']; ?>" style="color: black; text-decoration: none;">
                        <div class="card h-100">
                            <!-- Product image-->
                            <img class="card-img-top" src="./admin/products/uploads/<?php echo $products['image'] ?>" alt="..." />
                            <!-- Product details-->
                            <div class="card-body p-4">
                                <div class="text-center">
                                    <!-- Product name-->
                                    <h5 class="fw-bolder"><?php echo $products['name'] ?></h5>
                                    <div class="d-flex justify-content-center small text-warning mb-2">
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                        <div class="bi-star-fill"></div>
                                    </div>
                                    <!-- Product price-->
                                    $<?php echo $products['price'] ?>
                                </div>
                            </div>
                            <!-- Product actions-->
                            <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                                <div class="text-center"><a class="btn btn-outline-dark mt-auto" href="#">View options</a></div>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
        <!-- Phân trang -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <?php if ($page > 1) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>">Previous</a></li>
                <?php } ?>

                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>"><?php echo $i; ?></a></li>
                <?php } ?>

                <?php if ($page < $totalPages) { ?>
                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo $search; ?>&category=<?php echo $category_id; ?>">Next</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>
</section>

