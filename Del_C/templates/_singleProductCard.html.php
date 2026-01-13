<?php
include_once "includes/common.php";
?>
<div class="single-product-card">
  <div class="single-product-card__image-container" 
       style="background-image: url('assets/<?= esc($product['photo'] ?? 'default.jpeg') ?>');">
    <!-- <i class="single-product-card__love-icon fa fa-heart circle"></i> -->
    <img class="single-product-card__image" 
    src="assets/<?= esc($product['photo']?? 'default.jpeg')?>" alt="itemName"> 
  </div>

  <div class="single-product-card__info text-font-16">
      <h2 class="single-product-card__heading"><?= esc($product["categoryName"]) ?></h2>
      <p class="single-product-card__category"><span class="product-label">Product Name:</span> <?=esc($product['itemName']??'N/A')?></p>

     <!-- Display sale price if available and greater than 0.
     If so, also show original price with strikethrough if it's different.
     Otherwise, show only the original price. -->

      <?php if(!empty($product['salePrice']) && $product['salePrice'] > 0) : ?>
        <p class="single-product-card__sale-price current-price">
          <span class="product-label">Sale Price:</span> 
          $<?=esc(number_format($product['salePrice'],2))?>
        </p>
        <?php if(!empty($product['price']) && $product['price'] > 0 && $product['price']!= $product['salePrice']) : ?>
        <p class="single-product-card__price">
          <span class="product-label">Original Price:</span>
          <span style="text-decoration: line-through;">
          $<?=esc(number_format($product['price'], 2));?>
    </span>
        </p>
      <?php endif; ?>
      <?php else: ?>
        <p class="single-product-card__price">
          <span class="product-label">Original Price:</span>
          $<?=esc(number_format($product['price'], 2));?>
        </p>
      <?php endif; ?>  

      <p class="single-product-card__description"><span class="product-label">Description:
        </span> <?=esc($product['description']??'N/A')?>
      </p>
       <!-- Updated form for Add to Cart and Buy Now -->
      <form action="processCart.php" method="POST" class="single-product-card__actions flex">
        <input type="hidden" name="productId" value="<?= esc($product['itemId'] ?? '') ?>">
        <input type="hidden" name="itemName" value="<?= esc($product['itemName']) ?>">
        <input type="hidden" name="price" value="<?= esc((isset($product['salePrice']) && $product['salePrice'] > 0) ? $product['salePrice'] : $product['price']) ?>">
        <input type="hidden" name="categoryName" value="<?= esc($product['categoryName']) ?>">
        <input type="hidden" name="quantity" value="1">

        <button type="submit" name="action" value="add" class="single-product-card__buy-now round-edges-btn">
          Add to Cart
        </button>
        <!-- <button type="submit" name="action" value="buy" class="single-product-card__buy-now round-edges-btn">
          Buy Now
        </button> -->
      </form>
  </div> 
  
</div>
  
  
  
  
  
  
 


