<?php 

// TODO: define default- ul-class

// $ulClassForCategory = isset($ulClass) ? $ulClassForCategory : 'default-ul-class';

/* $ulClass holds the CSS class for the <ul> element to apply specific styling for category navigation, keeping it separate from styles used in the top navigation and footer.
*/
$ulClassForCategory = $ulClassForCategory ?? 'default-ul-class';?>

<ul class="<?= esc($ulClassForCategory) ?>">
  <?php  
    foreach ($categories as $category):?>
      <li>
        <a href="category.php?id=<?= (int)$category['categoryId']?>" class="category-nav-link">
         <?= esc($category['categoryName']) ?>
        </a>
      </li>
    <?php endforeach; ?>
</ul>


 