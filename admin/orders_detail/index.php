<?php

if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'orders-detail';
}
switch ($view) {
     case 'orders-detail':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list.php";
          include_once "./include/footer.php";

          break;
     case 'delete-order-detail':
          include_once "delete-order-detail.php";
          include_once "./config/DBUntil.php";
          break;
}
