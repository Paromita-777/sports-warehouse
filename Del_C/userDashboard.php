<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// protect this page from unauthorised access
Auth::protect();

// If you want to restrict only to users other than 'admin'
if ($_SESSION['role'] === 'admin') {
    header("Location: adminDashboard.php");
    exit();
}

// Config
$title = "User Dashboard";

// Start output buffering (trap output - don't display it yet)
ob_start();
$username = $_SESSION['username'];

// Capture success message from session, if any
$successMessage = '';
if (!empty($_SESSION['successMessage'])) {
    $successMessage = htmlspecialchars($_SESSION['successMessage']);
    // Included the success message template
    include_once "templates/_success.html.php";
    unset($_SESSION['successMessage']);
}

?>
<!-- welcome text -->
<div class="welcome-text flex">
  <p class="dashboard__welcome-text">
    🎉 Welcome <?= htmlspecialchars($username) ?>!<br>
  </p>
  <!-- TODO:add button to view cart item -->
</div>

<?php
// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the page-specific template
  include_once "templates/_userDashboard.html.php";

?>