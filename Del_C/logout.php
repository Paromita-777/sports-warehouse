<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Logged out";

// Start output buffering (trap output - don't display it yet)
ob_start();

Auth::logout();

// Include the page-specific template
  include_once "templates/_loggedOut.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>