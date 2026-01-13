<?php

  // Common includes for main PHP pages (controllers)
  require_once "includes/common.php";
  require_once "includes/helpers.php";

  // Include email sending functionality
  // require_once INCLUDES_DIR . "emailHelpers.php";

  // Config
  $title = "Contact Form";

  // Start output buffering
  ob_start();

  // Check if form has been submitted
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["submitContactForm"])){
    
    // Collection of all errors for this submission 
        $errors = [];

    // Get data passed to this page ($_POST superglobal array)
      $firstName = $_POST["firstName"] ?? "";
      $lastName = $_POST["lastName"] ?? "";
      $contactNumber = $_POST['contactNumber'] ?? "";
      $email = $_POST["email"] ?? "";
      $question = $_POST['question'] ?? "";

    // Normalise/sanitize data
      $firstName = trim($firstName);
      $lastName = trim($lastName);
      $email = trim($email);
      $contactNumber = trim($contactNumber);
      $question = trim($question);
    
    // validate firstName
      if ($firstName === "")
        $errors["firstName"] = "First Name is required";
      else if (strlen($firstName) < 2)
        $errors["firstName"] = "First name must be more than two characters.";

    // validate lastName
      if ($lastName === "")
        $errors["lastName"] = "Last Name is required";
      else if (strlen($lastName) < 2)
        $errors["lastName"] = "Last name must be more than two characters.";

    // validate contact number
      if ($contactNumber === "")
        $errors['contactNumber'] = 'Contact number is required.';
      else if (!preg_match('/^\d{10}$/', $contactNumber))
        $errors['contactNumber'] = "Invalid contact number. Please enter a 10-digit phone number.";

    // validate email
      if ($email === "")
        $errors['email'] = "Email is required.";
      else if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = "Invalid email pattern.";

    // validate question area
      if (strlen($question) > 255) {
        $errors['question'] = "Your question cannot exceed 255 characters.";
      }
    
    // Check if we have errors (invalid data)
    if (count($errors) > 0) {

      // Store errors and old input in session
       $_SESSION['errors'] = $errors;
       $_SESSION['contactFormInputs'] = [
         'firstName' => $firstName,
         'lastName' => $lastName,
         'contactNumber' => $contactNumber,
         'email' => $email,
         'question' =>$question
       ];

       // Redirect back to the form page
        header("Location: contactForm.php");
        exit();
    }
    // display success  in confirmation page
    else{
      $_SESSION['contactFormInputs'] = [
            'firstName' => $firstName,
            'lastName' => $lastName,
            'contactNumber' => $contactNumber,
            'email' => $email,
            'question' =>$question
          ];
      $_SESSION['success'] = true;
      header("Location: contactForm.php");
      exit();
    } 
  }
  // If form not submitted via post - Redisplay the blank form again(1st time display)
  else{
    if (isset($_SESSION['success'])) {
        include "templates/_contactFormConfirmation.html.php";
        unset($_SESSION['success']);
    } else {
        include "templates/_contactForm.html.php";
    }
  }
  // Stop output buffering
  $content = ob_get_clean();

/* Clear old error messages and form inputs from the session 
 after they have been displayed to prevent them from showing again on refresh
*/
  unset($_SESSION['errors'], $_SESSION['contactFormInputs']);
  
  // Include the main layout template
  include_once "templates/_layout.html.php";