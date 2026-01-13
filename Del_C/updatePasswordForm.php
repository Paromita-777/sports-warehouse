<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";
include "includes/helpers.php";

//protect this page from unauthorised access
Auth::protect();

// Page configuration
$title = "Update Password Form";

// Store form errors and success message
$errors = [];

// Start output buffering (trap output - don't display it yet)
ob_start();

//  Get logged-in username and role from session
$username = $_SESSION['username'];
$role = $_SESSION ['role'];


// Handle password update form submission
  if(($_SERVER['REQUEST_METHOD'] === 'POST') && isset($_POST['submitUpdatePasswordForm'])){
  
       // Sanitize and retrieve form inputs
      $currentPassword = trim($_POST['currentPassword']);
      $newPassword = trim($_POST['newPassword']);
      $confirmPassword = trim($_POST['confirmPassword']);

      // Basic validation checks
     
      if(empty($currentPassword)){
        $errors['currentPassword'] = "Current Password field can't be left blank.";
      }
      if(empty($newPassword)){
        $errors['newPassword'] = "New Password field can't be left blank.";
      }elseif (!preg_match(PASSWORD_PATTERN, $newPassword)) {
      $errors['newPassword'] = "New password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character (!@#$%^&*).";
    }
      if(empty($confirmPassword)){
        $errors['confirmPassword'] = "Confirm Password field can't be left blank.";
      }
      if(!empty($newPassword) && !empty($confirmPassword)&&
      $newPassword !== $confirmPassword){
          $errors['confirmPassword'] = "Password do not match.";
      }

      // If no validation errors, proceed to check credentials
      if(empty($errors)){

        // checking if user exists  and password matches
        if (Auth::doesUserExistAndPasswordMatch($username, $currentPassword)) {
          
            // Try updating the password in the database
            if (Auth::updateUserPassword($username, $newPassword)) {
                // On success, set success message with username included
                $_SESSION['successMessage'] = "Hi! " . htmlspecialchars($username) . ", your password updated successfully.";
                if($role === 'admin'){
                  header('Location: adminDashboard.php');
                  exit();
                }
                else{
                  header('Location: userDashboard.php');
                  exit();
                }
                
            }else {
              $msg = "updatePasswordForm: [" . date("Y-m-d H:i:s") . "] Failed to update password for user '{$username}'";
              error_log($msg);
              $errors['updatePassword'] = "Failed to update password. Please try again later.";
            }
        } else {
           $msg = "updatePasswordForm: [" . date("Y-m-d H:i:s") . "] Password verification failed for user '{$username}'";
          error_log($msg);
          $errors['updatePassword'] = "Something went wrong. Please check your information and try again.";
        }
      }
      // Store errors in session
      if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        // Redirect back to the form page
        header("Location: updatePasswordForm.php"); 
        exit();
    }
  }
  
  // Display the form with messages
  include_once "templates/_updatePasswordForm.html.php";

// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// checking which layout to render based on role
if($role === 'admin')
{
  // Include the layout 
    include_once "templates/_adminDashboard.html.php";
}
else{
   // Include the layout 
  include_once "templates/_userDashboard.html.php";
}
?>


