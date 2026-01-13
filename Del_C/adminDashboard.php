<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// protect this page from unauthorised access
Auth::protect();

// Only allow user with role 'admin'
if ($_SESSION['role'] === 'user') {
  header("Location: userDashboard.php");
  exit();
}

// Config
$title = "Admin";

// Start output buffering (trap output - don't display it yet)
ob_start();

$username = $_SESSION['username'];
// $role = $_SESSION ['role'];

// Capture success message from session, if any
$successMessage = '';
if (!empty($_SESSION['successMessage'])) {
  $successMessage = esc($_SESSION['successMessage']);
  // Included the success message template
  include_once "templates/_success.html.php";
  unset($_SESSION['successMessage']);
}

?>
<!-- welcome text -->
<div class="welcome-text flex">
  <p class="dashboard__welcome-text">
    🎉 Welcome to the Admin Dashboard, Captain <?= esc($username) ?>!<br>
      Your control panel is ready. From this very spot, you can:</p>
    <ul class="welcome-text-list">
       <li>🗂️ Organize product categories like a pro</li>
      <li>🛒 Keep the product catalog in tip-top shape</li>
      <li>📊 Keep an eye on system activity like a true guardian</li>
    </ul>
    <p>Let the admin adventures begin! 🚀</p>
</div>

<?php
// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the page-specific template
  include_once "templates/_adminDashboard.html.php";
?>