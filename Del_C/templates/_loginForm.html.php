<div class="login-form-container">

<i class="login-form-container__icon fa-regular fa-user text-font-40"></i>
<h1 class="login-form-container__heading" >LOGIN </h1>


<?php 
if (isset($_SESSION['errorMessage'])) {
  $errorMessage = $_SESSION['errorMessage'];
  unset($_SESSION['errorMessage']);
  if (!empty($errorMessage)) {
    include TEMPLATES_DIR . "_error.html.php";
  }
} 
?>

<form id ="loginForm" class="login-form" action="loginForm.php" method="post" novalidate>
  <fieldset class="flex">
    <legend class="sr-only">Login Information</legend>

    <div class="form-row">
      <i class="fa-solid fa-user"></i>
      <input 
      type="text" 
      id="username" 
      name="username" 
      minlength="4" 
      maxlength="20" 
      pattern="^[a-zA-Z0-9_]+$"
      placeholder="Username" 
      aria-label="Username" 
      required 
      <?= setValue("username") ?>>
    </div>

    <div class="form-row">
      <i class="fa-solid fa-lock"></i>
      <input 
      type="password" 
      id="password" 
      name="password" 
      placeholder="Password" 
      aria-label="Password" 
      required
      <?= setValue("password") ?>>
    </div>

    <div class="form-row">
      <button class="login-form__button" 
      type="submit" 
      name="submitloginForm">
      Login
    </button>
    </div>

   <a href="signUpForm.php" class="clickable-div-link">
      <div class="">
        <p>New user? Sign up here</p>
      </div>
  </a>
    
  </fieldset>
</form>
</div> 

