<div class="form-container">
  <h1 class="">Product Add/Update Form</h1>

  <p class="text-font-18">Complete the form to add a new product or update an existing one.</p>

  <form id="productForm" class="form-base product-form" action="productForm.php" method="post" enctype="multipart/form-data">

      <?php if (!empty($_SESSION['edit'])): ?>
        <input type="hidden" name="edit" value="<?= htmlspecialchars($_SESSION['edit']) ?>">
      <?php endif; ?>


    <fieldset>
      <legend> Product Details</legend>

      <!-- Item Name -->
      <div class="form-row flex">
        <label for="itemName">Item name: </label>
        <input type="text"
          id="itemName"
          name="itemName"
          placeholder="Enter Product Name:"
          required
          maxlength="150"
          value = "<?= isset($product['itemName']) ? htmlspecialchars($product["itemName"]) : ''?>">
      </div>

       <!-- Item Photo (file upload)-->
      <div class="form-row flex">
        <label for="photo">Photo: </label>
        <input type="file"
          id="photo"
          name="photo"
          accept="image/*">
      </div>


      <!-- Price(Not NULL)-->
      <div class="form-row flex">
        <label for="price">Price: </label>
        <input type="number"
                id="price"
                name="price"
                placeholder="e.g., 50.00"
                step ="0.01"
                min="1"
                required
                value = "<?= isset($product['price'])?htmlspecialchars($product["price"]) :'' ?>">
      </div>

      <!-- Sale Price (NULL)-->
      <div class="form-row flex">
        <label for="salePrice">Sale Price: </label>
        <input type="number"
                id="salePrice"
                name="salePrice"
                placeholder="e.g., 30.00"
                step ="0.01"
                value = "<?= isset($product['salePrice'])?htmlspecialchars($product["salePrice"]) :'' ?>">
      </div>

        <!-- Description (optional)-->
        <div class="form-row flex">
        <label for="description">Description: </label>
        <textarea id="description"
                  name="description"
                  placeholder="Enter description:"
                  maxlength="2000"><?= isset($product['description']) ? htmlspecialchars($product['description']) : '' ?>
        </textarea>
        </div>


         <!-- Featured (not NULL) -->
          <div class="form-row flex">
              <label for="featured">Featured:</label>
              <select id="featured" name="featured" required>
                <option value="">Select</option>
                <option value="1" <?= (isset($product['featured']) && $product['featured'] === '1') ? 'selected' : '' ?>>Yes</option>
                <option value="0" <?= (isset($product['featured']) && $product['featured'] === '0') ? 'selected' : '' ?>>No</option>
              </select>
              <?php if (!empty($errors['featured'])): ?>
                <span class="error"><?= $errors['featured'] ?></span>
              <?php endif; ?>
          </div>

         
        
        <!-- Category dropdown from DB -->
          <div class="form-row flex">
              <label for="categoryId">Category:</label>
              <select id="categoryId" name="categoryId" required>
                <option value="">Select Category</option>
                <?php foreach ($categories as $category): ?>
                  <option value="<?= $category['categoryId'] ?>"
                  <?= (isset($product['categoryId']) && $product['categoryId'] == $category['categoryId']) ? 'selected' : '' ?>>
                  <?= htmlspecialchars($category['categoryName']) ?>
                </option>
                <?php endforeach; ?>
              </select>
              <?php if (!empty($errors['categoryId'])): ?>
                <span class="error"><?= $errors['categoryId'] ?></span>
              <?php endif; ?>
          </div>

    </fieldset>
    
    <div class="form-row flex">
      <button class="save-button"
        type="submit"
        name="saveProductForm">
        Save
      </button>
      <!-- cancel link -->
      <button type="button" class="cancel-button" onclick="window.location.href='productManagement.php?cancel=true';">Cancel</button>

    </div>
  </form>
</div>