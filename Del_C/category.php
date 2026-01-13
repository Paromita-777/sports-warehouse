<?php
// Common includes for main PHP pages (controllers)
require_once  "includes/common.php";

// Validate 'id' parameter from the query string as an integer
  $categoryId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
  if ($categoryId === false || $categoryId <= 0) {
    die('Invalid category ID.');
  }
  
   // Start output buffering (trap output - don't display it yet)
    ob_start();

  try {

    // Create instances of Item and Category classes with DB access
      $item = new Item($db);
      $category = new Category($db);
    
    // Load category details for the given ID
     $category->loadCategoryById($categoryId);
    
    // Retrieve the category name to use in the page
     $categoryName = $category->getCategoryName();

    //Set dynamic page title based on the category 
    $title = $categoryName;
    
    // Get all products/items associated with this category
     $filteredProductsByCategory = $item->getItemByCategoryId($categoryId);
    
        // Display error message if no products found, otherwise show them
        if (empty($filteredProductsByCategory)){
            $errorMessage = "No products available in this category.";
            include_once "templates/_error.html.php";
        }
        else {
          $products = $filteredProductsByCategory;
          include "templates/_products.html.php";
        }

  } catch (Exception $ex) {
    // log the exception  with message, file, and line number
    error_log("Exception caught in category controller: " 
            . $ex->getMessage()
            . " in " . $ex->getFile()
            . ":" . $ex->getLine());
    
     // Show a generic error message to the user         
    $errorMessage = "No products available in this category.";
    include_once "templates/_error.html.php";
  }

  // Stop output buffering - store output into the $content variable
    $content = ob_get_clean();
    
  // Include the layout (e.g., _layout.html.php contains the full HTML structure)
    include_once "templates/_layout.html.php";
            
?>