<?php
if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'index';
}
switch ($view) {
     case 'index':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list-user.php";
          include_once "./include/footer.php";
          break;
     case 'update-user':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "update-user.php";
          include_once "./config/DBUntil.php";
          include_once "./include/footer.php";
          break;
     default:
          echo "View not found";
          break;
}
?>