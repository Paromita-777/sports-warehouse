<div class="form-container form-container--update">

<i class="form-container__icon fa-solid fa-key text-font-40"></i>

<h1 class="form-container__heading form-container__heading--update" >Change Your Password</h1>
<p>Your password called — it’s ready for retirement. Enter its replacement below!</p>

<?php 
$errors = $_SESSION['errors'] ?? [];
if(!empty($errors)){
  include "templates/_errorSummary.html.php"; 
  unset($_SESSION['errors']);
}
?>

<form id ="updatePasswordForm" class="form" action="updatePasswordForm.php" method="post">
  <fieldset>
    <legend class="">User Information</legend>

    <!-- current password -->
    <div class="form-row flex password-row">
      <label for="currentPassword">Current Password:</label>
      <input 
      type="password" 
      id="currentPassword" 
      name="currentPassword" 
      placeholder="Current Password" 
      required>
      <i class="fa-regular fa-eye toggle-password" data-target="currentPassword"></i>
    </div>

     <!-- New Password -->
    <div class="form-row flex password-row">
      <label for="newPassword">New Password:</label>
      <input 
      type="password" 
      id="newPassword" 
      name="newPassword" 
      placeholder="New Password" 
      pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*])[A-Za-z\d.!@#$%^&*]{8,}$" 
      title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character (!@#$%^&* or .)" 
      required>
      <i class="fa-regular fa-eye toggle-password" data-target="newPassword"></i>
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
      <button class="save-button" type="submit" name="submitUpdatePasswordForm">Change Password</button>
      <a href="authRedirect.php" class="cancel-button">Cancel</a>
    </div>
  </fieldset>
</form>
</div> 

