<?php
if (isset($_GET['id']) && isset($_GET['id_order'])) {
     $id = $_GET['id'];
     $id_order = $_GET['id_order'];
     include_once "../config/DBUntil.php";
     $db = new DBUntil();
     // var_dump($id_order);
     $test = $db->select("SELECT * FROM orders WHERE id = $id_order");
     var_dump($test[0]['id']);
     $iddel = $test[0]['id'];
     $db->delete("orders", "id = $iddel");

     $db->delete("bill", "id = $id");
     
     // echo "<script>alert('Xoa thanh cong');</script>";
     header("location: index.php?view=bill");
}
?>
