<?php

// Common includes
require_once "includes/common.php";
include_once "includes/helpers.php";

// protect this page from unauthorised access
Auth::protect();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['errorMessage'] = "Access denied. Admins only.";
    header("Location: loginForm.php"); 
    exit();
}

$title = "Product Management";
ob_start();

$item = new Item($db);
$category = new Category($db);
$successMessage = '';
$errorMessage = '';
$username = $_SESSION['username'] ?? 'Admin';

// Clear session messages if cancel was clicked
if (isset($_GET['cancel'])) {
    unset($_SESSION['successMessage'], $_SESSION['errorMessage'], $_SESSION['product'], $_SESSION['edit']);
    header("Location: productManagement.php");
    exit();
}

try {
    // 1. Handle "Update" button click: redirect to form with data
    if (isset($_GET['edit'])) {
        $editId = intval($_GET['edit']);

        if ($editId > 0) {
            // fetch product details from the db based on id
            $productData = $item->getItemByItemIdReturnsArray($editId); 
            print_r($productData);

            if ($productData) {
                $_SESSION['product'] = $productData;
                $_SESSION['edit'] = $editId;
                header("Location: productForm.php");
                exit();
            } else {
                $_SESSION['errorMessage'] = "Product with ID {$editId} not found.";
                header("Location: productManagement.php");
                exit();
            }
        }
    }

    // 2. Handle "Add" or "Update" form submission (redirected back from productForm.php)
    if (isset($_SESSION['product'])) {
        $productData = $_SESSION['product'];
        $editId = $_SESSION['edit'] ?? null;

        // Set item properties
        $item->setItemName($productData['itemName']);
        $item->setItemPrice($productData['price']);
        /*
        Retrieve salePrice from product data, defaulting to null if not set.
        If salePrice is an empty string or null, explicitly set it to null to comply with the typed property requirement (?float).
         Otherwise, cast the value to float before setting it.
        */
        $salePriceInput = $productData['salePrice'] ?? null;
        $salePrice = (
            $salePriceInput === '' || 
            $salePriceInput === null) ? 
            null : (float) $salePriceInput;

        $item->setItemSalePrice($salePrice);
        $item->setItemDescription($productData['description'] ?? null);
        $item->setItemFeatured($productData['featured']);
        $item->setItemCategoryId($productData['categoryId']);

        if (!empty($productData['photo'])) {
            $item->setItemPhoto($productData['photo']);
        }

        if ($editId === null) {
            $newId = $item->insertItem();
            $_SESSION['successMessage'] = "New product inserted with ID: {$newId}";
        } else {
            $item->updateItem($editId);
            $_SESSION['successMessage'] = "Product ID {$editId} updated successfully!";
        }

        unset($_SESSION['product'], $_SESSION['edit']);
        header("Location: productManagement.php");
        exit();
    }

    // 3. Handle delete item
    if (isset($_POST['deleteProduct'])) {
        $id = intval($_POST['id']);
        if ($id) {
            try {
                $success = $item->deleteItem($id);
                $_SESSION['successMessage'] = $success
                    ? "Item deleted successfully!"
                    : "Failed to delete item.";
            } catch (Exception $ex) {
                $_SESSION['errorMessage'] = "Error deleting item.";
                error_log($ex->getMessage());
            }
        } else {
            $_SESSION['errorMessage'] = "Invalid Item ID for deletion.";
        }

        header("Location: productManagement.php");
        exit();
    }

    // 4. Fetch product list for display
    $products = $item->getItems();
    $linkedStatus = [];

    foreach ($products as $product) {
        $itemId = $product['itemId'];
        $linkedStatus[$itemId] = $item->hasLinkedItems($itemId);
    }

    // 5. Load product management template
    if (empty($products)) {
        $errorMessage = "We're sorry, but there are no items available at the moment. Please check back later.";
        include_once('templates/_error.html.php');
    } else {
        include_once "templates/_productManagement.html.php";
    }

} catch (Exception $ex) {
    $_SESSION['errorMessage'] = "A fatal error occurred. Please try again.";
    error_log($ex->getMessage());
    header("Location: productManagement.php");
    exit();
}

$content = ob_get_clean();
include_once "templates/_adminDashboard.html.php";
