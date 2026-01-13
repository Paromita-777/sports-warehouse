<div class="form-container">
  <h1 class="">Checkout Form</h1>

  <p class="text-font-18">Complete the form below to finalize your order.</p>

  <!-- display form submission confirmation -->
   <?php 
  if(!empty($successMessage))
  include "templates/_success.html.php" 
  ?>

  <!-- display errors if any -->
  <?php 
  if(!empty($errors))
  include "templates/_errorSummary.html.php" 
  ?>

  <form id="checkoutForm" class="form-base checkout-form" action="checkout.php" method="post" novalidate>
    <fieldset>
      <legend> <i class="fas fa-shipping-fast"></i> Shipping Details</legend>

      <div class="form-row flex">
        <label for="firstName">First name</label>
        <input type="text"
          id="firstName"
          name="firstName"
          placeholder="Paromita"
          required
          maxlength="50"
          <?= setValue("firstName") ?>>
      </div>

      <div class="form-row flex">
        <label for="lastName">Last name</label>
        <input type="text"
          id="lastName"
          name="lastName"
          placeholder="Sarkar"
          required
          maxlength="50"
          <?= setValue("lastName") ?>>
      </div>

      <div class="form-row flex">
        <label for="street">Street Address</label>
        <input type="text"
          id="street"
          name="street"
          placeholder="123 Smith St"
          required
          <?= setValue("street") ?>>
      </div>

      <div class="form-row flex">
        <label for="suburb">Suburb</label>
        <input type="text"
          id="suburb"
          name="suburb"
          placeholder="Ryde"
          required
          <?= setValue("suburb") ?>>
      </div>

      <div class="form-row flex">
        <label for="state">State</label>
        <select id="state" name="state" required>
          <option value="">Select a state</option>
          <option value="NSW" <?= setSelected("state", "NSW") ?>>New South Wales</option>
          <option value="VIC" <?= setSelected("state", "VIC") ?>>Victoria</option>
          <option value="QLD" <?= setSelected("state", "QLD") ?>>Queensland</option>
          <option value="WA" <?= setSelected("state", "WA") ?>>Western Australia</option>
          <option value="SA" <?= setSelected("state", "SA") ?>>South Australia</option>
          <option value="TAS" <?= setSelected("state", "TAS") ?>>Tasmania</option>
          <option value="ACT" <?= setSelected("state", "ACT") ?>>Australian Capital Territory</option>
          <option value="NT" <?= setSelected("state", "NT") ?>>Northern Territory</option>
        </select>
      </div>

      <div class="form-row flex">
        <label for="postcode">Postcode</label>
        <input type="text"
          id="postcode"
          name="postcode"
          placeholder="2112"
          required
          <?= setValue("postcode") ?>>
      </div>

      <div class="form-row flex">
        <label for="contactNumber">Contact Number</label>
        <input type="text"
          id="contactNumber"
          name="contactNumber"
          placeholder="Enter your phone number"
          required
          <?= setValue("contactNumber") ?>>
      </div>

      <div class="form-row flex">
        <label for="email">Email</label>
        <input type="email"
          id="email"
          name="email"
          placeholder="xyz@email.com"
          required
          <?= setValue("email") ?>>
      </div>

    </fieldset>
    <fieldset>
      <legend><i class="fas fa-credit-card"></i> Payment Information</legend>

      <div class="form-row flex">
        <label for="nameOnCard">Name on Card</label>
        <input type="text"
          id="nameOnCard"
          name="nameOnCard"
          placeholder="John Citizen"
          required
          maxlength="50"
          <?= setValue("nameOnCard") ?>>
      </div>

      <div class="form-row flex">
        <label for="creditCardNumber">Credit Card Number</label>
        <input type="text"
          id="creditCardNumber"
          name="creditCardNumber"
          placeholder="1234 5678 9012 3456"
          required
          maxlength="19"
          <?= setValue("creditCardNumber") ?>>
      </div>

      <div class="form-row flex">
        <label for="expiryDate">Expiry Date</label>
        <input type="text"
          id="expiryDate"
          name="expiryDate"
          placeholder="MM/YY"
          required
          maxlength="10"
          <?= setValue("expiryDate") ?>>
      </div>

      <div class="form-row flex">
        <label for="csv">CSV</label>
        <input type="text"
          id="csv"
          name="csv"
          placeholder="123"
          required
          minlength="3"
          maxlength="3"
          <?= setValue("csv") ?>>
      </div>
    </fieldset>

    <div class="form-row flex">
      <button class="purchase-button"
        type="submit"
        name="submitCheckoutForm">
        Continue to checkout
      </button>
    </div>
  </form>
</div>

<?php $footerScripts = <<<HTML
  <script src="JS/form-validation.js"></script>
HTML;
?>