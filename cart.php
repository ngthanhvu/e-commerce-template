<?php
include_once "includes/header.php";
include_once "includes/navbar.php";
include_once "cart-services.php";
echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>';

$couponValue = 0;
$couponCode = '';
$errorMsg = '';

$subTotal = 0;
$db = new DBUntil();
$cartItems = $db->select("SELECT * FROM cart");
foreach ($cartItems as $key => $value) {
    $subTotal += $value['price'] * $value['quantity'];
    $_SESSION['total'] = $subTotal;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['coupon_code'])) {
    $couponCode = $_POST['coupon_code'];
    $coupon = $db->select("SELECT * FROM Coupons WHERE Code = '$couponCode' AND IsActive = 1 AND ExpiryDate >= CURDATE()");
    
    if ($coupon) {
        $coupon = $coupon[0];
        $couponValue = $coupon['DiscountAmount'] > 0 ? $coupon['DiscountAmount'] : $subTotal * ($coupon['DiscountPercentage'] / 100);
    } else {
        $errorMsg = 'Invalid or expired coupon code.';
    }
}
?>

<div class="container">
     <div class="contentbar">
          <div class="row">
               <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card m-b-30">
                         <div class="card-header">
                              <h5 class="card-title">Cart</h5>
                         </div>
                         <div class="card-body">
                              <div class="row justify-content-center">
                                   <div class="col-lg-10 col-xl-8">
                                        <div class="cart-container">
                                             <div class="cart-head">
                                                  <form action="update-cart.php" method="post">
                                                       <div class="table-responsive">
                                                            <table class="table table-borderless">
                                                                 <thead>
                                                                      <tr>
                                                                           <th scope="col">#</th>
                                                                           <th scope="col">Photo</th>
                                                                           <th scope="col">Product</th>
                                                                           <th scope="col">Qty</th>
                                                                           <th scope="col">Price</th>
                                                                           <th scope="col">Action</th>
                                                                      </tr>
                                                                 </thead>
                                                                 <tbody>
                                                                      <?php
                                                                      foreach ($cartItems as $key => $value) {
                                                                      ?>
                                                                           <tr>
                                                                                <th scope="row"><?php echo $key + 1; ?></th>
                                                                                <td><img src="./admin/products/uploads/<?php echo $value['img']; ?>" class="img-fluid" width="35" alt="product"></td>
                                                                                <td><?php echo $value['name']; ?></td>
                                                                                <td>
                                                                                     <div class="form-group mb-0">
                                                                                          <input type="number" class="form-control" name="cartQty[<?php echo $value['product_id']; ?>]" value="<?php echo $value['quantity']; ?>">
                                                                                     </div>
                                                                                </td>
                                                                                <td>$<?php echo $value['price']; ?></td>
                                                                                <td>
                                                                                     <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                                                     <a href="<?php echo 'cart-handle.php?id=' . $value['product_id'] . '&action=remove'; ?>" class="btn btn-sm btn-danger">Remove</a>
                                                                                </td>
                                                                           </tr>
                                                                      <?php
                                                                      }
                                                                      ?>
                                                                 </tbody>
                                                            </table>
                                                       </div>
                                                  </form>
                                             </div>

                                             <div class="cart-body">
                                                  <div class="row">
                                                       <div class="col-md-12 order-2 order-lg-1 col-lg-5 col-xl-6">
                                                            <div class="order-note">
                                                                 <form method="POST" action="">
                                                                      <div class="form-group">
                                                                           <div class="input-group">
                                                                                <input type="search" class="form-control" name="coupon_code" placeholder="Coupon Code" aria-label="Search" aria-describedby="button-addonTags" value="<?php echo htmlspecialchars($couponCode); ?>">
                                                                                <div class="input-group-append">
                                                                                     <button class="input-group-text" type="submit" id="button-addonTags">Apply</button>
                                                                                </div>
                                                                           </div>
                                                                      </div>
                                                                 </form>
                                                                 <?php if ($errorMsg): ?>
                                                                      <div class="alert alert-danger" role="alert">
                                                                           <?php echo $errorMsg; ?>
                                                                      </div>
                                                                 <?php endif; ?>
                                                            </div>
                                                       </div>
                                                       <div class="col-md-12 order-1 order-lg-2 col-lg-7 col-xl-6">
                                                            <div class="order-total table-responsive ">
                                                                 <table class="table table-borderless text-right">
                                                                      <tbody>
                                                                           <tr>
                                                                                <td>Sub Total :</td>
                                                                                <td>$<?php echo number_format($subTotal, 0); ?></td>
                                                                           </tr>
                                                                           <tr>
                                                                                <td>Coupon :</td>
                                                                                <td>$<?php echo number_format($couponValue, 0); ?></td>
                                                                           </tr>
                                                                           <tr>
                                                                                <td class="f-w-7 font-18">
                                                                                     <h4>Amount :</h4>
                                                                                </td>
                                                                                <td class="f-w-7 font-18">
                                                                                     <h4>$<?php
                                                                                     $total = $subTotal - $couponValue;
                                                                                     // var_dump($total);
                                                                                     $_SESSION['beforeTotal'] = $total;
                                                                                     if ($total > 0) {
                                                                                          echo number_format($total, 0);
                                                                                     } else {
                                                                                          echo "0";
                                                                                     }
                                                                                     ?></h4>
                                                                                </td>
                                                                           </tr>
                                                                      </tbody>
                                                                 </table>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="cart-footer text-right">
                                                  <form action="test.php?id=<?php echo $cartItems[0]['product_id'] ?>" method="post">
                                                       <?php           
                                                       foreach ($cartItems as $items) { ?>
                                                            <input type="hidden" name="cart[<?= $items['product_id'] ?>][product_id]" value="<?= $items['product_id'] ?>">
                                                            <input type="hidden" name="cart[<?= $items['product_id'] ?>][quantity]" value="<?= $items['quantity'] ?>">
                                                            <input type="hidden" name="cart[<?= $items['product_id'] ?>][total]" value="<?= $total ?>">
                                                            <input type="hidden" name="cart[<?= $items['product_id'] ?>][price]" value="<?= $items['price'] ?>">
                                                            <input type="hidden" name="cart[<?= $items['product_id'] ?>][cart_id]" value="<?= $items['id'] ?>">
                                                            <?php } ?>
                                                       <button type="submit" class="btn btn-success my-1">Checkout<i class="ri-arrow-right-line ml-2"></i></button>
                                                  </form>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
