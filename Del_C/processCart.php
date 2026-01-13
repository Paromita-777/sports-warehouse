<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// starting session to store cart data
session_start();

// sanitize and get POST data
$productId = $_POST['productId'] ?? '';
$itemName = $_POST['itemName'] ?? '';
$price = $_POST['price'] ?? 0;
$quantity = $_POST['quantity'] ?? 1;
$categoryName = $_POST['categoryName'] ?? '';
$action = $_POST['action'] ?? '';

$productId = trim($productId);
$itemName = trim($itemName);
$categoryName = trim($categoryName);
$price = floatval($price);
$quantity = intval($quantity);


// SQL query to get the image path
$sql = <<<SQL
    SELECT photo
    FROM item i
    WHERE itemId = :itemId
SQL;

// Prepare and bind
$stmt = $db->prepareStatement($sql);
$stmt->bindValue(":itemId", $productId, PDO::PARAM_INT);

// Execute
$photoFilePath = $db->executeSQLReturnOneValue($stmt);
// testing purpose
// print_r($photoFilePath)

$image = $photoFilePath?? 'default.jpg'; // fallback imagephotoFilePath

// // TODO:testing, will remove this code later
// echo '<pre>';
// print_r([
//     'productId' => $productId,
//     'itemName'  => $itemName,
//     'price'     => $price,
//     'quantity'  => $quantity,
//     'categoryName' => $categoryName,
//     'action'    => $action
// ]);
// echo '</pre>';

// Validate essential inputs
if (empty($productId) || empty($itemName) || $price <= 0 || $quantity <= 0)  {
    $errorMessage = "Invalid product data. Please try again.";
    include_once ('templates/_error.html.php');
    exit;
}
// initializing cart
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
// Add or update item in the cart
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity'] += $quantity;
} 
else {
    $_SESSION['cart'][$productId] = [
        'itemName'     => $itemName,
        'categoryName' => $categoryName,
        'price'        => $price,
        'quantity'     => $quantity,
         'image'        => $image
    ];
}

// TODO: testing, will remove this code later
// echo '<pre>';
// print_r($_SESSION['cart']);
// echo '</pre>'; 

// Redirect based on action
if ($action === 'buy') {
    header('Location: checkout.php');
} else {
    header('Location: viewCart.php');
}
exit;
?>

