<?php 
 // Common includes for main PHP pages (controllers)
  require_once "includes/common.php";
?>
<div class="success-message">
  <h2>Success</h2>
  <p><?= esc($successMessage )?? "No success message provided." ?></p>
</div>