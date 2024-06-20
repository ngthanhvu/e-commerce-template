<?php
if (isset($_GET['view'])) {
     $view = $_GET['view'];
} else {
     $view = 'dashboard';
} 
switch ($view) {
     case 'dashboard':
          include_once "./include/header.php";
          include_once "./include/slidebar.php";
          include_once "list.php";
          include_once "./include/footer.php";
          break;
}
?>