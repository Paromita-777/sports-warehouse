
  <div class="confirmation-container">
  <?php if (isset($errorMessage)): ?>
    <h1 style="color: red;">⚠️ Error</h1>
    <p><?= esc($errorMessage) ?></p>
    <a class="back-button" href="viewProducts.php">Back to Products</a>
  <?php else: ?>
    <h1>✅ Success!</h1>
    <p>Hi <?= esc($customerName) ?>,</p>
    <p>Thank you for your order. It has been received successfully.</p>
    <p>Your shopping order ID is <span class="order-id"><?= esc($shoppingOrderID) ?></span>.</p>
    <p>Please keep this ID for future reference.</p>
    <a class="back-button" href="viewProducts.php">Continue Shopping</a>
  <?php endif; ?>
</div>
  
