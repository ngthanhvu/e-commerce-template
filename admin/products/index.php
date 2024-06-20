<?php

if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'product';
}
switch ($view) {
     case 'product':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list.php";
          include_once "./include/footer.php";

          break;
     case 'add-product':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "add-product.php";
          include_once "./config/DBUntil.php";
          include_once "./include/footer.php";
          break;
     case 'delete-product':
          include_once "delete-product.php";
          include_once "./config/DBUntil.php";
          break;
     case 'update-product':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "update-product.php";
          include_once "./config/DBUntil.php";
          include_once "./include/footer.php";
          break;
}
