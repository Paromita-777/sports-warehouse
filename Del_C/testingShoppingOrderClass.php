<?php

// Common includes such as class definitions and constants
require_once "includes/common.php";

try
{

  // Create new object instance (using the constructor)
  $shoppingOrder = new ShoppingOrder($db);

  $shoppingOrder->setFirstName('Ryan');
  $shoppingOrder->setLastName('Roy');
  $shoppingOrder->setAddress('343, Lachlan Avenue, NSW- 2113');
  $shoppingOrder->setContactNumber('0456768790');
  $shoppingOrder->setEmail('ryan.roy@gmail.com');
  $shoppingOrder->setcreditCardNumber('5353 5646 7082 6756');
  $shoppingOrder->setExpiryDate('04/2027');
  $shoppingOrder->setNameOnCard('Ryan Roy');
  $shoppingOrder->setCsv('789');
  $isshoppingOrder = $shoppingOrder->insertCustomerDetails();

  if($isshoppingOrder){
    echo "Customer details inserted successfully!";
  }
  else{
   echo "Customer details insertion failed!";
  }

  
  
} catch (Exception $ex) {

  // "Handle" exception
  echo "<p>Catastrophic error: {$ex->getMessage()}</p>";

}