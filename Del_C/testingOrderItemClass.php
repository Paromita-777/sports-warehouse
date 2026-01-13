<?php

// Common includes such as class definitions and constants
require_once "includes/common.php";



try
{
   $cart = $_SESSION['cart'] ?? [];
  $orderItem = new OrderItem($db);

  $newShoppingOrderId =10;
  if(!empty($cart)){
    foreach($cart as $itemId => $item){
             // Validate itemId
            if (!is_numeric($itemId) || intval($itemId) <= 0) {
                $errors['general'] = "Invalid item in the cart.";
                break;
            }
             $itemId = intval($itemId);

             // Validate quantity
              if (!isset($item['quantity']) || !is_numeric($item['quantity']) || intval($item['quantity']) < 1) {
                  $errors['general'] = "Invalid quantity for item ID $itemId.";
                  break;
              }
              $quantity = intval($item['quantity']);

              // Validate price
                if (!isset($item['price']) || !is_numeric($item['price']) || floatval($item['price']) <= 0) {
                    $errors['general'] = "Invalid price for item ID $itemId.";
                    break;
                }
              $price = floatval($item['price']);
              
              if(!$orderItem->insertOrderDetails($itemId, $newShoppingOrderId, $quantity, $price)){
                echo"Error in inserting data";
              }
            }

  }else{
    echo("cart is empty!");
  }

          
}catch(Exception $ex){

    // Showing user-friendly message
    $errors['general'] = "An unexpected error occurred while processing your order. Please try again later.";

}