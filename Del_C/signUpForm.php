<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";
include "includes/helpers.php";

// Page configuration
$title = "Sign Up Form";

// Store form errors and success message
$errors = [];
$successMessage ='';

// Start output buffering (trap output - don't display it yet)
ob_start();


// Handle create new user form submission

if(($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submitSignUpForm'])){


  // Sanitize and retrieve form inputs
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

  // Basic validation checks
      if (empty($username)) {
        $errors['username'] = "Username is required.";
      }elseif(!preg_match(USERNAME_PATTERN, $username)){
        $errors['username'] ="Username must start with a letter and be 3 to 51 characters long. Only letters, numbers, dots, and underscores are allowed.";
      }

     if(empty($password)){
        $errors['password'] = "Password field can't be left blank.";
      }elseif (!preg_match(PASSWORD_PATTERN, $password)) {
      $errors['password'] = "Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character (!.@#$%^&*).";
      }  
    
    if(empty($confirmPassword)){
      $errors['confirmPassword'] = "Confirm Password field can't be left blank.";
    }

    if(!empty($password) && !empty($confirmPassword)&&
      $password !== $confirmPassword){
      $errors['confirmPassword'] = "Password do not match.";
    }

   // If no validation errors, proceed to create new user

   if(empty($errors)){
    try{
       $newUserId = Auth::createUser($username, $password);
        if(!empty($newUserId)){
            $successMessage = "Hi! " . htmlspecialchars($username) . ", your have successfully created an account, and user userId is : " .htmlspecialchars($newUserId);
            $_POST = []; // clear form data
        } else {
            $errors['username'] = "Failed to create an account. Please try again later.";
        }
    }catch(Exception $ex){
       // Check if error is duplicate entry (SQLSTATE 23000, code 1062)
        if ($ex->getCode() == 23000 && strpos($ex->getMessage(), '1062 Duplicate entry') !== false) {
            $errors['username'] = "Username '" . htmlspecialchars($username) . "' is already taken. Please choose a different username.";
        } else {
            // For other DB exceptions, you can log the error and show a generic message
            error_log("Database error creating user: " . $ex->getMessage());
            $errors['username'] = "An unexpected error occurred. Please try again later.";
        }
   }
}
}
// Display the form with messages
  include_once "templates/_signUpForm.html.php";

// Stop output buffering - store output into the $content variable
  $content = ob_get_clean();

// Include the layout (e.g., _layout.html.php contains the full HTML structure)
  include_once "templates/_layout.html.php";
?>


