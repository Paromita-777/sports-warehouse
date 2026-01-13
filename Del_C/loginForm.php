<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";
require_once "includes/helpers.php";

// Config
$title ="Login Form";

// Start output buffering (trap output - don't display it yet)
ob_start();

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submitloginForm'])){

   // get data passed to this page
    $username = trim($_POST['username'] ?? "");
    $password = $_POST['password'] ?? "";

    // make sure both username or password are supplied

    if($username === "" || $password === ""){
      // set error message
      $errorMessage = "Username and password are required.";
    }else{
      try {
        //Authenticate user (check username and password)
        // user will be redirected to adminDashboard page on success
           Auth::login($username, $password); 

           $_SESSION['errorMessage'] = "Username or password incorrect.";
        } catch (Exception $ex) {
          $errorMessage = "Error loggin in: " . $ex->getmessage();
      }
      header("Location: loginform.php");
      exit();
}
    // Re-display the login form with messages
       include_once "templates/_loginForm.html.php";
}
// $errorMessage = $_SESSION['errorMessage'] ?? "";
// // clear it after displaying
// unset($_SESSION['errorMessage']); 

include_once "templates/_loginForm.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
include_once "templates/_layout.html.php";
?>