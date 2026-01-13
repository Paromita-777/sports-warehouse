<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Ensure the user is authenticated before accessing this page
Auth::protect();

// Page title
$title = "Auth Redirect";

// Get and sanitize the username and the role from the session
$username = trim($_SESSION['username'] ?? '');
$role = trim($_SESSION['role'] ?? '');

// Redirect user based on their role

if($role === 'admin'){
  header("Location: adminDashboard.php");
  exit();
}
else{
 header("Location: userDashboard.php");
  exit();
}
?>