<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
     <!-- Navbar Brand-->
     <a class="navbar-brand ps-3" href="../index.php">ADMIN Manage</a>
     <!-- Sidebar Toggle-->
     <button style="color: #fff;" class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="" href="#!"><i class="fas fa-bars"></i></button>
     <!-- Navbar Search-->
     <!-- <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
          <div class="input-group">
               <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
               <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
          </div>
     </form> -->
</nav>
<div id="layoutSidenav">
     <div id="layoutSidenav_nav">
          <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
               <div class="sb-sidenav-menu">
                    <div class="nav">
                         <div class="sb-sidenav-menu-heading">Core</div>
                         <a class="nav-link" href="./index.php?view=index">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Người dùng
                         </a>
                         <a class="nav-link" href="./index.php?view=product">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Sản phẩm
                         </a>
                         <a class="nav-link" href="./index.php?view=category">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Danh mục
                         </a>
                         <a class="nav-link" href="./index.php?view=order">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Đặt hàng
                         </a>
                         <a class="nav-link" href="./index.php?view=orders-detail">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Chi tiết đặt hàng
                         </a>
                         <a class="nav-link" href="./index.php?view=dashboard">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Thống kê
                         </a>
                         <a class="nav-link" href="./index.php?view=bill">
                              <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                              Quản lý hóa đơn
                         </a>
                    </div>
               </div>

          </nav>
     </div>
     <div id="layoutSidenav_content">
          <?php
          $view = isset($_GET['view']) ? $_GET['view'] : 'index';
          // var_dump($view);
          switch ($view) {
               case 'index':
                    include_once "./users/list-user.php";
                    break;
               case 'product':
                    include_once "./products/list.php";
                    break;
               case 'add-product':
                    include_once "./products/add-form.php";
                    break;
               case 'delete-product':
                    include_once "./products/delete-product.php";
                    break;
               case 'update-product':
                    include_once "./products/update-form.php";
                    break;
               case 'delete-user':
                    include_once "./users/delete-user.php";
                    break;
               case 'update-user':
                    include_once "./users/update-user-form.php";
                    break;
               case 'category':
                    include_once "./category/list.php";
                    break;
               case 'add-category':
                    include_once "./category/add-category-form.php";
                    break;
               case 'delete-category':
                    include_once "./category/delete-category.php";
                    break;
               case 'update-category':
                    include_once "./category/update-category-form.php";
                    break;
               case 'order':
                    include_once "./orders/list.php";
                    break;
               case 'delete-order':
                    include_once "./orders/delete-order.php";
                    break;
               case 'delete-order-detail':
                    include_once "./orders_detail/delete-order-detail.php";
                    break;
               case 'orders-detail':
                    include_once "./orders_detail/list.php";
                    break;
               case 'dashboard':
                    include_once "./dashboard/list.php";
                    break;
               case 'bill':
                    include_once "./bill/list.php";
                    break;
          }
          ?>
     </div>
</div>