<?php

   // Common includes for main PHP pages (controllers)
    require_once "includes/common.php";
    
    // checking for existence of query parameter
     if(!empty($_GET['query']) && strlen(trim($_GET['query'])) >= 2): 
     // trim and validate the data( e.g. not empty, reasonable length)
      $searchTerm = trim($_GET['query']);

       // Sanitization
      $sanitizedSearchTerm = esc($searchTerm, ENT_QUOTES, 'UTF-8');

      $item = new Item($db);

     
    // Start output buffering (trap output - don't display it yet)
      ob_start();

    //Get the product details from the database using the search term

    $matchedItems= $item->searchItems($sanitizedSearchTerm);

    // check if any records are returned

    if(empty($matchedItems)):
      $errorMessage = "No items matched your search.";
       include_once ('templates/_error.html.php');
    else: 
      $products =$matchedItems;
       include_once ('templates/_products.html.php');
    endif;  

    // config
    $title = $sanitizedSearchTerm. " - Search Results";
    // Stop output buffering - store output into the $content variable
    $content = ob_get_clean();

    // Include the layout (e.g., _layout.html.php contains the full HTML structure)
    include_once "templates/_layout.html.php";
   
else: 
      echo "Please enter atleast two characters." ;
    endif; 
?> 