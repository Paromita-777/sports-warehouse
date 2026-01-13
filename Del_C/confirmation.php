<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Confirmation";

// Start output buffering (trap output - don't display it yet)
ob_start();


// Check and display success message
if (isset($_SESSION['successMessage'])) {
    $successMessage = $_SESSION['successMessage'];
    $customerName = $successMessage['customerName'] ?? 'Customer';
    $shoppingOrderID = $successMessage['shoppingOrderID'] ?? 'N/A';
    unset($_SESSION['successMessage']); // Clear the message after showing
} else {
    $customerName = 'Customer';
    $shoppingOrderID = 'N/A';
    $errorMessage = "No order was placed or session has expired.";
}
 

// Include the page-specific template
 include_once __DIR__ . "/templates/_cofirmation.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>