<?php
// get errors and old inputs from session 
$errors = $_SESSION['errors'] ?? [];
$inputs = $_SESSION['contactFormInputs'] ??[];
?>
<div class="form-container">
<h1 class="">Contact Form</h1>

<!-- include error message display template -->
<?php include TEMPLATES_DIR . "_errorSummary.html.php" ?>

<p class="text-font-18">Please fill out the form below and we'll get back to you as soon as possible.</p>

<form id="contactForm" class="form-base contact-form" action="contactForm.php" method="post" novalidate>
  <fieldset>
    <legend>Contact information</legend>

    <div class="form-row flex">
      <label for="firstName">First name</label>
      <input type="text" 
      id="firstName" 
      name="firstName" 
      placeholder="Paromita"
      required
      pattern="[A-Za-z\s]+" 
      title="Only letters and spaces are allowed" 
      <?= setValue("firstName") ?>
      >
    </div>

    <div class="form-row flex">
      <label for="lastName">Last name</label>
      <input type="text" 
      id="lastName" 
      name="lastName" 
      placeholder="Sarkar" 
      pattern="[A-Za-z\s]+" 
      title="Only letters and spaces are allowed"
      <?= setValue("lastName") ?>
      >
    </div>

    <div class="form-row flex">
      <label for="contactNumber">Contact Number</label>
      <input type="text" 
      id="contactNumber" 
      name="contactNumber" 
      pattern="\d{10}" 
      placeholder="Enter your phone number" 
      required 
      title="Please enter a 10-digit number"
      inputmode="numeric"
      maxlength="10"
      <?= setValue("contactNumber") ?>
      >
    </div>

    <div class="form-row flex">
      <label for="email">Email</label>
      <input type="email" 
      id="email" 
      name="email" 
      placeholder="xyz@email.com" 
      <?= setValue("email") ?>
      >
    </div>

    <div class="form-row flex">
      <label for="question">Any Questions?</label>
      <textarea name="question" 
        id="question" 
        cols="30" 
        rows="4" 
        placeholder="Have a question? Type it here...">
        <?= getEncodedValue("question") ?>
      </textarea>
    </div>

    <div class="form-row flex">
      <button class="contact-form__button" 
      type="submit" 
      name="submitContactForm">
      Submit
    </button>
    </div>
    
  </fieldset>
</form>
</div>
