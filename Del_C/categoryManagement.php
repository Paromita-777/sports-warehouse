<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// protect this page from unauthorised access
Auth::protect();

// Check if the user is an admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    $_SESSION['errorMessage'] = "Access denied. Admins only.";
    header("Location: loginForm.php");
    exit();
}

// Config
$title = "Category Management";

// Start output buffering (trap output - don't display it yet)
ob_start();

try {
    $category = new Category($db);

    $successMessage = '';
    $errorMessage = '';
    $username = $_SESSION['username'] ?? 'Admin';

    // Handle POST requests
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Handle add category
        if (isset($_POST['addCategory'])) {
            try {
                $name = trim($_POST['categoryName']);
                if (!empty($name)) {
                    $category->setCategoryName($name);
                    $newCategoryId = $category->insertCategory();
                    $_SESSION['successMessage'] = "You have inserted category: {$name} successfully! The new category ID is: {$newCategoryId}.";
                } else {
                    $_SESSION['errorMessage'] = "Category name cannot be empty.";
                }
            } catch (PDOException $ex) {
                if ($ex->getCode() == '23000' && str_contains($ex->getMessage(), '1062 Duplicate entry')) {
                    $_SESSION['errorMessage'] = "Category '{$name}' already exists.";
                } else {
                    $_SESSION['errorMessage'] = "A database error occurred. Please try again.";
                    error_log($ex->getMessage());
                }
            } catch (Exception $ex) {
                $_SESSION['errorMessage'] = "Unexpected error occurred. Please try again.";
                error_log($ex->getMessage());
            }
            header("Location: categorymanagement.php");
            exit();
        }

        // Handle update category
        if (isset($_POST['updateCategory'])) {
            $id = intval($_POST['id']);
            $newName = trim($_POST['newName']);
            if ($id && !empty($newName)) {
                try {
                    $category->loadCategoryById($id);
                    $category->setCategoryName($newName);
                    $success = $category->updateCategory($id);
                    $_SESSION['successMessage'] = $success
                        ? "Category '{$newName}' updated successfully!"
                        : "Failed to update category '{$newName}'.";
                } catch (PDOException $ex) {
                    if ($ex->getCode() == '23000' && str_contains($ex->getMessage(), '1062 Duplicate entry')) {
                        $_SESSION['errorMessage'] = "Category '{$newName}' already exists.";
                    } else {
                        $_SESSION['errorMessage'] = "A database error occurred. Please try again.";
                        error_log($ex->getMessage());
                    }
                } catch (Exception $ex) {
                    $_SESSION['errorMessage'] = "Unexpected error occurred. Please try again.";
                }
            } else {
                $_SESSION['errorMessage'] = "Invalid input for update.";
            }
            header("Location: categorymanagement.php");
            exit();
        }

        // Handle delete category
        if (isset($_POST['deleteCategory'])) {
            $id = intval($_POST['id']);
            if ($id) {
                try {
                    $success = $category->deleteCategory($id);
                    $_SESSION['successMessage'] = $success
                        ? "Category deleted successfully!"
                        : "Failed to delete category.";
                } catch (Exception $ex) {
                    $_SESSION['errorMessage'] = "Error deleting category.";
                    error_log($ex->getMessage());
                }
            } else {
                $_SESSION['errorMessage'] = "Invalid category ID for deletion.";
            }
            header("Location: categorymanagement.php");
            exit();
        }
    }

    // Fetch categories
    $categories = $category->getCategories();

    $linkedStatus = [];

    foreach ($categories as $cat) {
        $catId = $cat['categoryId'];
        $linkedStatus[$catId] = $category->hasLinkedItems($catId);
    }

    if (empty($categories)) {
        $errorMessage = "We're sorry, but there are no categories available at the moment. Please check back later.";
        include_once TEMPLATES_DIR . '_error.html.php';
    } else {
        include_once TEMPLATES_DIR . '_categoryManagement.html.php';
    }
} catch (Exception $ex) {
    $_SESSION['errorMessage'] = "A fatal error occurred. Please try again.";
    error_log($ex->getMessage());
    header("Location: categorymanagement.php");
    exit();
}


// Stop output buffering - store output into the $content variable
$content = ob_get_clean();

// Include layout
include_once TEMPLATES_DIR.'_adminDashboard.html.php';
