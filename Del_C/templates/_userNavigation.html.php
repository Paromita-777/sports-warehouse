<div class="user-navigation-container flex">

  <?php include_once('templates/_login.html.php');?> 

  <div class="view-cart flex">
    <a href="viewCart.php"><i class="fas fa-shopping-cart"></i> <span> View Cart</span></a>
  </div>

  <div class="lozenge-button flex">
    <button class="btn">
    <span><?= $totalItem ?> items</span>
    </button> 
  </div>

</div>