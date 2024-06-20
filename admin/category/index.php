<?php

if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'category';
}
switch ($view) {
     case 'category':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list.php";
          include_once "./include/footer.php";

          break;
     case 'add-category':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "add-category.php";
          include_once "./config/DBUntil.php";
          include_once "./include/footer.php";
          break;
     case 'delete-category':
          include_once "delete-category.php";
          include_once "./config/DBUntil.php";
          break;
     case 'update-category':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "update-category.php";
          include_once "./config/DBUntil.php";
          include_once "./include/footer.php";
          break;
}
