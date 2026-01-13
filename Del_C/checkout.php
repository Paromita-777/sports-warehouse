<?php
// Common includes for main PHP pages (controllers)
require_once "includes/common.php";
include_once "includes/helpers.php";

// Config
$title = "Checkout Page";

// Store form errors and success message
$errors = [];
$successMessage ='';

// Start output buffering
ob_start();
try{
  // Handle checkout form submission
  if(($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submitCheckoutForm']))
  {
    // Sanitize and retrieve form inputs
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $street = trim($_POST['street']);
    $suburb = trim($_POST['suburb']);
    $state = trim($_POST['state']);
    $postcode = trim($_POST['postcode']);
    $contactNumber = trim($_POST['contactNumber']);
    $email = trim($_POST['email']);
    $creditCardNumber = trim($_POST['creditCardNumber']);
    $expiryDate = trim($_POST['expiryDate']);
    $nameOnCard = trim($_POST['nameOnCard']);
    $csv = trim($_POST['csv']);

    // validation checks
      if (empty($firstName)){
      $errors['firstName'] = "Firstname is required";
      }elseif (strlen($firstName) < 1 || strlen($firstName) > 50) {
      $errors['firstName'] = "Firstname must be 1 - 50 characters long";
      }  

      if (empty($lastName)){
        $errors['lastName'] = "Lastname is required";
      }elseif (strlen($lastName) < 1 || strlen($lastName) > 50) {
        $errors['lastName'] = "Lastname must be 1 - 50 characters long";
      }  

      if (empty($street) || empty($suburb) || empty($state) || empty($postcode)) {
          $errors['address'] = "Complete address is required";
      } else {
          $address = "$street, $suburb, $state $postcode";
          if (strlen($address) > 200) {
              $errors['address'] = "Address must be 1 - 200 characters long";
          }
      }

      if (empty($contactNumber)){
        $errors['contactNumber'] = "Contact number is required";
      }elseif (strlen($contactNumber) > 20) {
        $errors['contactNumber'] = "Contact number must be 1 - 20 characters long";
      }elseif (!preg_match('/^\d+$/', $contactNumber)) {
        $errors['contactNumber'] = "Contact number must contain digits only";
      }

      if (empty($email)){
        $errors['email'] = "Email is required";
      }elseif (strlen($email) < 1 || strlen($email) > 255) {
        $errors['email'] = "Email must be 1 - 255 characters long";
      }elseif (!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
      }

      if (empty($creditCardNumber)){
        $errors['creditCardNumber'] = "Credit card number is required";
      }elseif (strlen($creditCardNumber) > 19) {
         $errors['creditCardNumber'] = "Credit card number must be 16 digits or 19 characters with spaces";
      }elseif (!preg_match('/^(?:\d{16}|\d{4} \d{4} \d{4} \d{4})$/', $creditCardNumber)) {
        $errors['creditCardNumber'] = "Credit card number format is invalid.";
      }

      if (empty($expiryDate)) {
        $errors['expiryDate'] = "Expiry date is required";
    }elseif (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $expiryDate)) {
        $errors['expiryDate'] = "Expiry date must be in MM/YY format";
    }

    if (empty($nameOnCard)){
        $errors['nameOnCard'] = "Name on card is required";
      }elseif (strlen($nameOnCard) < 1 || strlen($nameOnCard) > 50) {
        $errors['nameOnCard'] = "Name on card must be 1 - 50 characters long";
    }

    if (empty($csv)) {
        $errors['csv'] = "CSV is required";
    }if (!preg_match('/^\d{3}$/', $csv)) {
        $errors['csv'] = "CSV must be exactly 3 digits long and contain digits only";
    }

  // // If no validation errors, proceed to insert customer details in database (shoppingOrder table)
  if(empty($errors)){
    
      // Instantiate the ShoppingOrder object and set all customer details
        $shoppingOrder = new ShoppingOrder($db);
        $shoppingOrder->setFirstName($firstName);
        $shoppingOrder->setLastName($lastName);
        $shoppingOrder->setAddress($address);
        $shoppingOrder->setContactNumber($contactNumber);
        $shoppingOrder->setEmail($email);
        $shoppingOrder->setcreditCardNumber($creditCardNumber);
        $shoppingOrder->setExpiryDate($expiryDate);
        $shoppingOrder->setNameOnCard($nameOnCard);
        $shoppingOrder->setCsv($csv);

      // Insert customer details and get new order ID
        $newShoppingOrderId  = $shoppingOrder->insertCustomerDetails();

        if($newShoppingOrderId){

          //Insert each item from the cart into order items table
          $cart = $_SESSION['cart'] ?? [];
          $orderItem = new OrderItem($db);

          foreach($cart as $itemId => $item){
             // Validate itemId is a positive integer
            if (!is_numeric($itemId) || intval($itemId) <= 0) {
                $errors['general'] = "Invalid item in the cart.";
                break;
            }
             $itemId = intval($itemId);

             // Validate quantity is numeric and at least 1
              if (!isset($item['quantity']) || !is_numeric($item['quantity']) || intval($item['quantity']) < 1) {
                  $errors['general'] = "Invalid quantity for item ID $itemId.";
                  break;
              }
              $quantity = intval($item['quantity']);

              // Validate price is numeric and greater than 0
                if (!isset($item['price']) || !is_numeric($item['price']) || floatval($item['price']) <= 0) {
                    $errors['general'] = "Invalid price for item ID $itemId.";
                    break;
                }

              // Ensure price is treated as a float for accurate calculations before database insertion 
              $price = floatval($item['price']);

              // Calculate total price for the item based on quantity purchased
              $totalPrice = $price * $quantity;  

              // Insert order item details, stop on failure
              if(!$orderItem->insertOrderDetails($itemId, $newShoppingOrderId, $quantity, $totalPrice)){
                $errors['general'] = "There was a problem placing your order. Please try again.";
                break;
              }
          }

          // Set success message in session and clear POST data and cart
          $_SESSION['successMessage'] = [
            'customerName' => htmlspecialchars($firstName),
            'shoppingOrderID' => htmlspecialchars($newShoppingOrderId)
          ];
          $_POST = [];

          // clear the cart after order 
          $_SESSION['cart'] = []; 
          header("Location:confirmation.php");
          exit();
        }else{
        $errors['general'] = "There was a problem placing your order. Please try again. ";
        }
  }
}

}catch(Exception $ex){
  // Log the exception
    error_log("Exception caught in checkout controller: " . $ex->getMessage() . 
              " in " . $ex->getFile() . ":" . $ex->getLine());

    // Showing user-friendly message
    $errors['general'] = "An unexpected error occurred while processing your order. Please try again later.";

}
// Include Checkout Form layout
include_once "templates/_checkout.html.php";

// Stop output buffering
$content = ob_get_clean();

// Include the main layout template
include_once "templates/_layout.html.php";
?>
