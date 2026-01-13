
<?php
  $successMessage = $_SESSION['successMessage'] ?? '';
  $errorMessage = $_SESSION['errorMessage'] ?? '';

  // Clear messages so they only show once
  unset($_SESSION['successMessage'], $_SESSION['errorMessage']);
?>

<div class="category-management">
<?php if (!empty($successMessage)): ?>
    <?php include TEMPLATES_DIR . '_success.html.php'; ?>
<?php endif; ?>

<?php if (!empty($errorMessage)): ?>
    <?php include TEMPLATES_DIR . '_error.html.php'; ?>
<?php endif; ?>

  <h1 class="category-management__title">Category Management</h1>

  <form class="category-management__form" method="POST">
    <input type="text" name="categoryName" id="categoryName" required placeholder="New Category Name">
    <button type="submit" name="addCategory">Add</button>
  </form>

  <table class="category-management__table">
    <thead>
      <tr>
        <th>Category Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if(!empty($categories)): ?>
        <?php foreach ($categories as $cat): ?>
        <tr>
          <td><?= esc($cat['categoryName']) ?></td>
          <td>
            <div class="category-management__actions">
              <form method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= esc($cat['categoryId']) ?>">
                <input class="category-management__input" type="text" name="newName" placeholder="New name" required>
                <button class="category-management__button category-management__button--update" type="submit" name="updateCategory">Update</button>
              </form>

              <form method="post" style="display:inline;">
              <input type="hidden" name="id" value="<?= esc($cat['categoryId'] )?>">
              <button 
                class="category-management__button category-management__button--delete" 
                type="submit" 
                name="deleteCategory" 
                onclick="return confirm('Delete this category?')"
                <?= (isset($linkedStatus[$cat['categoryId']]) && $linkedStatus[$cat['categoryId']]) ? 'disabled title="Category linked to items, cannot delete"' : '' ?>
              >
                Delete
              </button>
              </form>
            </div>
          </td>
        </tr>
      <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="2" style="text-align:center; color: red;">No categories found.</td></td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
