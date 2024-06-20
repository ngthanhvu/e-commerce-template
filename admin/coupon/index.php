<?php
if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'coupon';
}
switch ($view) {
     case 'coupon':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list.php";
          include_once "./include/footer.php";
          break;
     case 'add-coupon':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "add-coupon-form.php";
          include_once "./include/footer.php";
          break;
}
