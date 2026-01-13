<?php
// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Check if ID exists and is a number
if (isset($_GET['productId']) && ctype_digit($_GET['productId'])) :
    $itemId = (int)$_GET['productId'];
else :
    die('Invalid Item ID.');
endif;

// Start output buffering
ob_start();

// SQL query
$sql = <<<SQL
    SELECT `itemId`, `photo`, `salePrice`, `price`, `itemName`,`description`, c.categoryName
    FROM item i
    JOIN category c ON c.categoryId = i.categoryId
    WHERE itemId = :itemId
SQL;

// Prepare and bind
$stmt = $db->prepareStatement($sql);
$stmt->bindValue(":itemId", $itemId, PDO::PARAM_INT);

// Execute
$filteredProductsByItemId = $db->executeSQL($stmt);

// Check and act based on results
if (!empty($filteredProductsByItemId)) :
    $product = $filteredProductsByItemId[0];
    $title = $product['categoryName'];
     include_once "templates/_singleProductCard.html.php";
else :
    $content = "<p>Sorry, the product you're looking for does not exist.</p>";
    include_once "templates/_layout.html.php";
    exit;
endif;

// Capture output
$content = ob_get_clean();

// Final layout include
include_once "templates/_layout.html.php";
?>
