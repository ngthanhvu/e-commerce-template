<?php
// include_once "./include/header.php";
// include_once "./include/slidebar.php";
// include_once "./include/main.php";
// include_once "./include/footer.php";
?>
<?php

// $view = isset($_GET['view']) ? $_GET['view'] : 'index';
if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'index';
}
// var_dump($view);
switch ($view) {
     case 'index':
          include_once "./users/index.php";
          break;
     case 'product':
          include_once "./products/index.php";
          break;
     case 'add-product':
          include_once "./products/add-product.php";
          break;
     case 'delete-product':
          include_once "./products/delete-product.php";
          break;
     case 'update-product':
          include_once "./products/update-product.php";
          break;
     case 'delete-user':
          include_once "./users/delete-user.php";
          break;
     case 'update-user':
          include_once "./users/update-user.php";
          break;
     case 'category':
          include_once "./category/index.php";
          break;
     case 'add-category':
          include_once "./category/add-category.php";
          break;
     case 'delete-category':
          include_once "./category/delete-category.php";
          break;
     case 'update-category':
          include_once "./category/update-category.php";
          break;
     case 'order':
          include_once "./orders/index.php";
          break;
     case 'delete-order':
          include_once "./orders/delete-order.php";
          break;
     case 'delete-order-detail':
          include_once "./orders_detail/delete-order-detail.php";
          break;
     case 'orders-detail':
          include_once "./orders_detail/index.php";
          break;
     case 'dashboard':
          include_once "./dashboard/index.php";
          break;
     case 'bill':
          include_once "./bill/index.php";
          break;
     case 'delete-bill':
          include_once "./bill/delete-bill.php";
          break;
     case 'update-bill':
          include_once "./bill/update-bill.php";
          break;
     case 'coupon':
          include_once "./coupon/index.php";
          break;
     case 'add-coupon':
          include_once "./coupon/add-coupon.php";
          break;
     case 'delete-coupon':
          include_once "./coupon/delete-coupon.php";
          break;
}
