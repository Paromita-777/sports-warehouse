 <?php 
 // Common includes for main PHP pages (controllers)
  require_once "includes/common.php";
  ?>
<?php if (!empty($products)) : ?>
  <div class="products-container  section-gap flex"> 
  <?php foreach ($products as $product) : ?>
    <a href="productDetails.php?productId=<?= (int)$product['itemId'] ?>" class="product-link">
      
    <div class="product-card flex">
      <img class="product-image" 
      src="assets/<?= esc($product['photo']?? 'default.jpeg')?>" 
      alt="<?= esc($product['itemName']); ?>">

    <div class="product-price">
        <?php if(!empty($product['salePrice']) && $product['salePrice'] > 0) : ?>
          <!-- Display sale price if it's valid -->
          <p class="current-price text-center font-weight-400 text-font-15">$
            <?= esc(number_format($product['salePrice'], 2));?>
          </p>

        <?php if(!empty($product['price']) && $product['price'] > 0 && $product['price']!= $product['salePrice']) : ?>
          <!-- Display WAS normally, only strike the price -->
          <p class="old-price text-center font-weight-400 text-font-15"> WAS 
          <span class="was-price" style="text-decoration: line-through;">$
          <?= esc(number_format($product['price'], 2)); ?>
          </span>
          </p>
        <?php endif; ?>
        
        <?php else : ?>
          <!-- If sale price is not valid, just display the regular price -->
          <p class="current-price text-center font-weight-400 text-font-15"> $<?= esc(number_format($product['price'], 2)); ?>
          </p>
        <?php endif; ?>
    </div>

    <div class="product-details">
      <p class="product-name"><?= esc($product['itemName']); ?></p>
    </div>
    </div>
    </a>
  
  <?php endforeach; ?>
      </div>
  <?php else : ?>
        <p>No products are available right now. Please check back later.</p>
  <?php endif; ?>
        