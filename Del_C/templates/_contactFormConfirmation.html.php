<?php 
// Common includes for main PHP pages (controllers)
  require_once "includes/common.php";
  require_once "includes/helpers.php";

// Retrieve form inputs from session
    $inputs = $_SESSION['contactFormInputs'] ?? [];

// Extract values safely (with null coalescing fallback)
    $firstName = $inputs['firstName'] ?? '';
    $lastName = $inputs['lastName'] ?? '';
    $contactNumber = $inputs['contactNumber'] ?? '';
    $email = $inputs['email'] ?? '';

// Clear session data after use
unset($_SESSION['contactFormInputs']);
?>

<div class="contact-confirmation">
<h2>Contact Form Submission Confirmed!</h2>

<p>Thank you, <?= esc($firstName) ?> for reaching out! One of our team members will be in touch with you very soon.</p>

<h3>Contact Form Summary</h3>

<ul>
  <li>First name: <?= esc($firstName ?? "") ?></li>
  <li>Last name: <?= esc($lastName ?? "") ?></li>
  <li>Contact number: <?= esc($contactNumber ?? "") ?></li>
  <li>Email: <?= esc($email ?? "") ?></li>
</ul> 
</div>
