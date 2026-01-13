<?php

  // Common includes for main PHP pages (controllers)
  require_once "includes/common.php";

  // Config
  $title = "Cart";

  // Start output buffering
  ob_start();

//  TODO: update this page specific link
  include_once "templates/_viewCart.html.php";
  // Stop output buffering
  $content = ob_get_clean();

  // Include the main layout template
  include_once "templates/_layout.html.php";