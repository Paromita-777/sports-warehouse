<div class="form-container">

<h1 class="form-container__heading" >Sign Up </h1>

<?php 
/* Display error message if present, else success message if available.
  Nothing will be displayed if both are empty. */
if (!empty($errors)) {
    include "templates/_errorSummary.html.php"; 
} elseif (!empty($successMessage)) {
    include "templates/_success.html.php";
}
?>

<form id ="signUpForm" class="form" action="signUpForm.php" method="post">
  <fieldset>
    <legend class="">New User Information</legend>

    <!-- username -->

    <div class="form-row flex">
      <label for="username">Username:</label>
      <input 
      type="text" 
      id="username" 
      name="username" 
      minlength="4" 
      maxlength="20" 
      pattern="^[a-zA-Z][a-zA-Z0-9._]{2,50}$"
      placeholder="Username" 
      aria-label="Username" 
      required
      <?= setValue("username") ?>>
    </div>

     <!--  Password -->
    <div class="form-row flex password-row">
      <label for="password">Password:</label>
      <input 
      type="password" 
      id="password" 
      name="password" 
      placeholder="Password" 
      pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*])[A-Za-z\d.!@#$%^&*]{8,}$" 
      title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&* or .)" 
      required>
      <i class="fa-regular fa-eye toggle-password" data-target="password"></i>
    </div>

    <!-- Confirm  Password -->
    <div class="form-row flex password-row">
      <label for="confirmPassword">Confirm Password:</label>
      <input 
      type="password" 
      id="confirmPassword" 
      name="confirmPassword" 
      placeholder="Confirm Password" 
      required>
      <i class="fa-regular fa-eye toggle-password" data-target="confirmPassword"></i>
    </div>


    <!-- Buttons -->
    <div class="form-row flex">
      <button class="save-button" type="submit" name="submitSignUpForm"> Sign Up </button>
      <a href="loginForm.php" class="cancel-button">Cancel</a>
    </div>
  </fieldset>
</form>
</div> 

