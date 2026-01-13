<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Shop";

// Start output buffering (trap output - don't display it yet)
ob_start();

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>