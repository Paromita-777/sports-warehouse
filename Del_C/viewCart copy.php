<?php
// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Config
$title = "Cart Details";

// Start output buffering
ob_start();

$total = 0;

// fetching cart 
$cart = $_SESSION['cart'] ?? [];

// Handle item removal
if (isset($_GET['remove'])) {
    $removeId = $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    header("Location: viewCart.php");
    exit;
}

// Handle empty cart
if (isset($_GET['empty'])) {
    unset($_SESSION['cart']);
    header("Location: viewCart.php");
    exit;
}

// Handle quantity increase
if (isset($_GET['increase'])) {
    $id = $_GET['increase'];
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
    }
    header("Location: viewCart.php");
    exit;
}

// Handle quantity decrease
if (isset($_GET['decrease'])) {
    $id = $_GET['decrease'];
    if (isset($_SESSION['cart'][$id]) && $_SESSION['cart'][$id]['quantity'] > 1) {
        $_SESSION['cart'][$id]['quantity']--;
    }
    header("Location: viewCart.php");
    exit;
}

// Render cart or show empty message
if (empty($cart)) {
    echo '<p style="color: red; text-align: center; font-size: 16px; padding: 3rem;">
            Your cart is empty ! 
            <a href="viewProducts.php"> <i class="fa-solid fa-bag-shopping" style="color:black"></i> Go back to shop</a>
          </p>';
} else {
    include "templates/_viewCart.html.php";
}

// Stop output buffering
$content = ob_get_clean();

// Include the main layout template
include_once "templates/_layout.html.php";
?>
