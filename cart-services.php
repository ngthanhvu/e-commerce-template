<?php
// session_start();

class Cart
{
     public $items = array();
     public function __construct()
     {
          if (!isset($_SESSION['carts'])) {
               $_SESSION['carts'] = [];
          }
          // $_SESSION['carts'] = array();
          $this->items = $_SESSION['carts'];
     }
     public function add($product)
     {
          $productId = $product['id'];
          if (isset($this->items[$productId])) {
               echo "update";
               $this->items[$productId]['quantity']++;
          } else {
               echo "add";
               $product['quantity'] = 1;
               $this->items[$productId] = $product;
          }
          $this->setCart();
     }

     public function remove($productId)
     {
          // $productId = $this->items[$productId];
          if (isset($this->items[$productId])) {
               unset($this->items[$productId]);
          }
          $this->setCart();
     }

     public function clear()
     {
          $this->items = array();
          $this->setCart();
     }

     public function update($quantity, $productId)
     {
     }

     public function setCart()
     {
          $_SESSION['carts'] = $this->items;
     }

     public function getCart()
     {
          return $this->items;
     }

     public function getTotal()
     {
          $sum = 0;
          foreach ($this->items as $product) {
               $sum += $product['price'] * $product['quantity'];
          }
          return $sum;
     }
}
