
<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

$item = new Item($db);
// Config
$title = "Product List";

// Start output buffering (trap output - don't display it yet)
ob_start();

 $allAvailableProducts = $item->getItems();
 
 // Handle empty result by rendering _error.html.php
if (empty($allAvailableProducts)):
    $errorMessage = "No products available now.";
    include_once "templates/_error.html.php";
else :
    $products = $allAvailableProducts;
    include "templates/_products.html.php";
endif;

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>