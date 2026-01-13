<?php

  /* Common includes for main PHP pages (controllers) */

  // Define constant that points to the root directory of the website, which helps when including files throughout your code when you don't know what the current directory is
  // ROOT_DIR will point to the "Del_C" folder
  // INCLUDES_DIR will point to the "Del_C/includes" folder
  // TEMPLATES_DIR will point to the "Del_C/templates" folder
  // PASSWORD_PATTERN - Defines a reusable constant for password validation pattern
   // USERNAME_PATTERN - Defines a reusable constant for username validation pattern
  define("ROOT_DIR", __DIR__ . "/../");
  define("INCLUDES_DIR", ROOT_DIR . "includes/");
  define("TEMPLATES_DIR", ROOT_DIR . "templates/");
  define("CLASSES_DIR", ROOT_DIR . "classes/");
  define("PASSWORD_PATTERN", '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[.!@#$%^&*])[A-Za-z\d.!@#$%^&*]{8,}$/');
  define("USERNAME_PATTERN", '/^[a-zA-Z][a-zA-Z0-9._]{2,50}$/');

  
  // Load class definitions
  require_once CLASSES_DIR . "Category.php";
  require_once CLASSES_DIR . "Item.php";
  require_once CLASSES_DIR . "ShoppingCart.php";
  require_once CLASSES_DIR . "CartItem.php";
  require_once CLASSES_DIR . "Auth.php";
  require_once CLASSES_DIR . "ShoppingOrder.php";
  require_once CLASSES_DIR . "OrderItem.php";

  // Load Composer's autoloader (created by Composer, not included with PHPMailer)
  // require_once ROOT_DIR . "vendor/autoload.php";

  // Include "secrets" that are not tracked by Git
  require_once INCLUDES_DIR . "secrets.php";

  // Database connection (create DBAccess instance in the $db variable)
  require_once INCLUDES_DIR . "database.php";

  // Open the database connection
  $db->connect();


  // Start session (if it's not already started)
  if (!isset($_SESSION)) {
    session_start();
  }
// TODO: update this
  // Get the shopping cart from the session
  // $cart = $_SESSION["cart"] ?? new ShoppingCart();

// TODO:update this code in shopping cart class as method
// Fetch the cart and count total items
$cart = $_SESSION['cart'] ?? [];
$totalItem = 0;
  foreach ($cart as $item) {
    $totalItem += intval($item['quantity']);
}
 
  /**
   * Escapes a value for safe usage in HTML. Wrapper for `htmlspecialchars()`.
   *
   * @param string|integer $valueToEscapeForHtml The value to escape for HTML usage
   * @return string An HTML-encoded value
   */
  function esc(string|int $valueToEscapeForHtml): string {
    return htmlspecialchars($valueToEscapeForHtml);
  }
  
