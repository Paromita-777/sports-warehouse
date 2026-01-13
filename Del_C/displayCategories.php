<?php

      // Common includes for main PHP pages (controllers)
      require_once "includes/common.php";

      try {
          // Create new object instance (using the constructor)
          $category = new Category($db);

          // get category name
          $categories= $category->getCategories();

          // check if any records are returned
            if(empty($categories)):
            $errorMessage = "We're sorry, but there are no categories available at the moment. Please check back later.";
            include_once ('templates/_error.html.php');
          else: 
            // Include the page-specific template
            include "templates/_categories.html.php";
          endif; 
      } catch (Exception $ex) {

        // "Handle" exception
        echo "<p>Catastrophic error: {$ex->getMessage()}</p>";
      }
      
    
  ?>