<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

$item = new Item($db);

// Config
$title = "Home";

// Start output buffering (trap output - don't display it yet)
ob_start();

// Display featured products 

$featuredProducts = $item->getfeaturedItems();

// Handle empty result by rendering _error.html.php
if (empty($featuredProducts)):
    $errorMessage = "No products available now.";
    include_once "templates/_error.html.php";
else :
    // Include the page-specific template
      $products =  $featuredProducts;
      include_once "templates/_indexPage.html.php";
endif;



// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>