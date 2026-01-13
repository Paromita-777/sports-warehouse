<div class="cart flex">
  <!-- left column: Conternt -->
  <div class="cart__content flex">
    <h1 class="cart__heading">Shopping Cart</h1>
    <div class="cart__header grid-column">
      <div>Product</div>
      <div>Unit Price</div>
      <div>Quantity</div>
      <div>Subtotal</div>
      <div>Remove</div> 
    </div>  

  <?php
   // Initialize cart totals
  $totalItems = 0;
  $totalPrice = 0;

  foreach($cart as $productId => $item):
    $itemName = esc($item['itemName']);
    $category = esc($item['categoryName']);
    $price = number_format($item['price'], 2);
    $quantity = intval($item['quantity']);
    $subtotal = number_format($item['price'] * $quantity, 2);

     // Update totals
      $totalItems += $quantity;
      $totalPrice += $item['price'] * $quantity;
  ?>

    <div class="cart__item grid-column">
    <!-- 1. Product -->
    <div class="cart__item-details">
      <img src="assets/<?= $item['image'] ?>" alt="<?= esc($item['itemName']) ?>" class="cart__item-image">
      <div class="item-details">
        <div class="cart__item-category"> Category: <?=esc($category)?></div>
        <div class="cart__item-item-name"> <?=htmlspecialchars_decode($itemName)?></div>
      </div>
    </div>

    <!-- 2. Unit Price -->
    <div class="cart__item-price">$<?=esc($price)?></div>

    <!-- 3. Quantity -->
     <div class="cart__item-quantity">
      <a href="viewCart.php?decrease=<?=urlencode($productId)?>" class="cart__quantity-btn"> - </a>
      <span class="cart__quantity-count"><?=esc($quantity)?></span>
      <a href="viewCart.php?increase=<?=urlencode($productId)?>" class="cart__quantity-btn"> + </a> 
    </div>

    <!-- 4. Subtotal -->
    <div class="cart__item-subtotal">$<?= esc($subtotal) ?></div>

    <!-- 5. Remove -->
    <div class="cart__item-remove">
      <a href="viewCart.php?remove=<?= urlencode($productId) ?>">
        <i class="fa-solid fa-trash"></i>
       </a>
    </div>
    </div>
    <?php endforeach; ?>

    <div class="cart__back-button">
      <a href="viewProducts.php" class="cart__back-button-link">← Back to Shop </a>
    </div>
  </div>

  <?php
  // TODO: will fetch the discount from DB and also fetch tax from DB or set amount 
  $tax = 0;
  $discount = 0; // Default discount amount
  $grandTotal = $totalPrice - $discount; 
  ?>

  <!-- Right Column: Summary -->
  <div class="cart__summary flex">
    <h2 class="summary__heading">Summary</h2>
      
    <div class="summary__row">
      <div class="summary__label">Items in Cart:</div>
      <div class="summary__value"><?= esc($totalItems) ?></div>
    </div>

    <div class="summary__row">
      <div class="summary__label">Subtotal:</div>
      <div class="summary__value"><?= esc(number_format($totalPrice, 2)) ?></div>
    </div>

    <div class="summary__row">
      <div class="summary__label">Tax:</div>
      <div class="summary__value">$<?= esc(number_format($tax, 2)) ?></div>
    </div>

    <div class="summary__row summary__row--discount">
      <div class="summary__label">Discount:</div>
      <div class="summary__value">$<?= esc(number_format($discount, 2)) ?></div>
    </div>

    <div class="summary__row">
      <div class="summary__label">Order Total:</div>
      <div class="summary__value">$<?= esc(number_format($grandTotal, 2)) ?></div>
    </div>

    <div class="checkout-link">
      <a href="checkout.php" class="summary__button text-font-14">PROCEED TO CHECKOUT
      </a>
    </div>
    
  </div>

</div>




