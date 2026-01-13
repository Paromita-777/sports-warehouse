<?php

  // Common includes for main PHP pages (controllers)
  require_once "includes/common.php";
  require_once "includes/helpers.php";

  // Config
  $title = "Product add/update Form";


  // Start output buffering
  ob_start();

  // Fetching category name and id from db
    $category = new Category($db);
    $categories = $category->getCategories();
    $item = new Item($db);
    $products = $item->getItems();
    $username = $_SESSION['username'] ?? 'Admin';
    
  try{

    // Check if form has been submitted
    if (isset($_POST["saveProductForm"])) {

        $errors = [];
        $product = [];
        
        // Collect form data and sanitize
        $product['itemName'] = trim($_POST['itemName'] ?? '');
        $product['price'] = trim($_POST['price'] ?? '');
        $product['salePrice'] = trim($_POST['salePrice'] ?? '');
        $product['description'] = trim($_POST['description'] ?? '');
        $product['featured'] = $_POST['featured'] ?? '';
        $product['categoryId'] = $_POST['categoryId'] ?? '';

        // Validate
          if (
            $product['itemName'] === '' || 
            strlen($product['itemName']) < 2 ||
            strlen($product['itemName']) > 150
             ) {
              $errors['itemName'] = 'Product name is required and must be between 2 to 150 characters.';
          }

          if (
            !isset($product['price']) || 
            !is_numeric($product['price']) ||
             $product['price'] <= 0
             ) {
              $errors['price'] = 'Price must be a positive number and cannot be null.';
            }

          if (
            $product['salePrice'] !== '' &&
             (!is_numeric($product['salePrice']) || 
             floatval($product['salePrice'])< 0)
             ) {
              $errors['salePrice'] = 'Sale price must be a non-negative number.';
          }

          if(strlen($product['description'])>2000)
          {
            $errors['description'] = 'Description cannot exceed 2000 characters.';
          }

          if (!in_array($product['featured'], ['0', '1'])) {
              $errors['featured'] = 'Please select if the product is featured.';
          }

          if ($product['categoryId'] === '') {
              $errors['categoryId'] = 'Please select a category.';
          }

          // Handle file upload (optional)
          if (!empty($_FILES['photo']['name'])) {
              $uploadDir = 'assets/';
              $filename = basename($_FILES['photo']['name']);
              $uploadPath = $uploadDir . $filename;
              if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadPath)) {
                  $product['photo'] = $filename;
              } else {
                  $errors['photo'] = 'File upload failed.';
              }
          }else{
            // Keep existing photo if no new photo is uploaded
            $product['photo'] = $_POST['existingPhoto'] ?? null;
          }

          // if errors re-display the form with errors
          if(!empty($errors)){
            include "templates/_productForm.html.php";
          }
          else{
            // store productForm details in session and redirect to productManagemet.php for operations
            $_SESSION['product'] = $product;
            $_SESSION['edit'] = $_POST['edit'] ?? null;
            header("Location: productManagement.php");
            exit;
          }
  }
  else {
          // Initial form load, no submission yet
          $product = $_SESSION['product'] ?? [];
          include "templates/_productForm.html.php";
    }
}
  catch(Exception $ex){
    $errorMessage = "An unexpected error occurred: " . $ex->getMessage();
      include "templates/_error.html.php";
  }
  

  // // Stop output buffering
  $content = ob_get_clean();
  
  // // Include the main layout template
  include_once "templates/_adminDashboard.html.php";
  