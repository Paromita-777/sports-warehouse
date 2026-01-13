<?php
  $successMessage = $_SESSION['successMessage'] ?? '';
  $errorMessage = $_SESSION['errorMessage'] ?? '';

  unset($_SESSION['successMessage'], $_SESSION['errorMessage']);

  $editId = $_GET['edit'] ?? null;
  $showAddForm = isset($_GET['add']);
?>

<div class="product-management">

<?php if (!empty($successMessage)): ?>
  <?php include 'templates/_success.html.php'; ?>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
  <?php include 'templates/_error.html.php'; ?>
<?php endif; ?>

<h1 class="product-management__title">Product Management</h1>


  <!-- Add / Update Product Button -->
  <div class="productAddUpdate"> 
    
  <p class="product-management__subtitle">Add new products, update existing ones, or manage your catalog easily from here.</p>
    <a href="productForm.php" class="product-management__button product-management__button--add">
      Add Product
    </a>
  </div>


<!-- Product List Table -->
<table class="product-management__table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Photo</th>
      <th>Name</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $product): ?>
      <tr>
        <td><?= htmlspecialchars($product['itemId']) ?></td>
        <td>
          
          <img src="assets/<?= htmlspecialchars($product['photo'] ??'default.jpeg')?>" alt="Product Image" style="width: 60px; height: auto;">
        </td>
        <td><?= htmlspecialchars($product['itemName']) ?></td>
        <td>
          <a href="?edit=<?= $product['itemId'] ?>" class="product-management__button product-management__button--update">Update</a>

          <form method="post" style="display:inline;">
            <input type="hidden" name="id" value="<?= $product['itemId'] ?>">
            <button 
              class="product-management__button product-management__button--delete" 
              type="submit" 
              name="deleteProduct"
              onclick="return confirm('Delete this product?')"
              <?= (isset($linkedStatus[$product['itemId']]) && $linkedStatus[$product['itemId']]) ? 'disabled title="Product linked to orders, cannot delete"' : '' ?>
            >
              Delete
            </button>
          </form>
        </td>
      </tr>

    <?php endforeach; ?>
  </tbody>
</table>
</div>
