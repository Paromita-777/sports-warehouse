<?php

/* 
  
  NOTE: When using this business object in a "real" webpage using user-supplied data:

  1. Get data from the user
  2. Validation (and sanitisation) - in the class or using FormValidator
  3. Image upload logic (if you have images)
  4. Create new object (from business object class)
  5. Assign property values, e.g. $object->setProperty("value")
  6. Insert/update into database
  7. Get new ID (if inserting) and display message to user

 */

// Common includes such as class definitions and constants
require_once "includes/common.php";


// try
// {
// just creating admin user for testing. 
//  Auth::createUser('admin','password','admin');
//   // Create new object instance (using the constructor)
//   $item = new Item($db);
//  $products = $item->getfeaturedItems();
//  $count = count($products);
// echo "Number of rows: $count";
 

  // Get a item from the database by its ID (load object properties)
  // $item->getItemByItemId(2);

  // $category->setCategoryName("   ");

  // Print item info
  // echo <<<HTML
  // <p>Name: {$item->getitemName()}, Description: {$item->getDescription()}</p>
  // HTML;


  /* 
   * TESTING: Adding a new item 
   */

  // // Create new object, add data, insert into datbase
  // $category = new Category();
  // $item->setItemName("Puma Active Training Duffel Bag");
  // $item->setItemPhoto("duffelBag.jpg ");
  // $item->setItemPrice(59.99);
  // $item->setItemSalePrice(30.00);
  // $item->setItemDescription("Durable and spacious, the Puma Active Training Duffel Bag is perfect for carrying your gear to the gym or field.");
  // $item->setItemFeatured(1);
  // $item->setItemCategoryId(5);
  // $updateStatus = $item->updateItem(13);
  // $item->setItemId(13);
  // $updateStatus = $item->deleteItem(13);
  
// if ($updateStatus) {
//     echo "Item {$itemId} deleted successfully!";
// } else {
//     echo "Unsuccessful";
// }

  // $item->insertItem();

  // $category->setDescription("This is a beautiful description from PHP...");
  // $newCategoryId = $category->insertCategory();

  // echo <<<HTML
  // <p>New category added successfully: {$newCategoryId}</p>
  // HTML;


  /* 
   * TESTING: Updating a category 
   */

  // // Get category from database, change its data, update in the datbase
  // $categoryIdToUpdate = 11;
  // $category = new Category();
  // $category->getCategory($categoryIdToUpdate);
  // // $category->setCategoryName("Edited in PHP");
  // $category->setDescription("This is an updated description from PHP...");
  // $updateSuccess = $category->updateCategory($categoryIdToUpdate);

  // if ($updateSuccess) {
  //   echo <<<HTML
  //   <p>✔ Category updated successfully: {$categoryIdToUpdate}</p>
  //   HTML;
  // } else {
  //   echo <<<HTML
  //   <p>☠ Category update failed: {$categoryIdToUpdate}</p>
  //   HTML;
  // }


  /* 
   * TESTING: Deleting a category 
   */

  // // Get category from database, change its data, update in the datbase
  // $categoryIdToDelete = 9;
  // $category = new Category();
  // $deleteSuccess = $category->deleteCategory($categoryIdToDelete);

  // if ($deleteSuccess) {
  //   echo <<<HTML
  //   <p>✔ Category deleted successfully: {$categoryIdToDelete}</p>
  //   HTML;
  // } else {
  //   echo <<<HTML
  //   <p>☠ Category delete failed: {$categoryIdToDelete}</p>
  //   HTML;
  // }

// } catch (Exception $ex) {

  // "Handle" exception
  // echo "<p>Catastrophic error: {$ex->getMessage()}</p>";

// }