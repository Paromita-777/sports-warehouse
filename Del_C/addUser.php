<?php

// Common includes for main PHP pages (controllers)
require_once "includes/common.php";

// Testing purpose: to enter user in database 

// $usernames =['Paromita', 'Aarohi', 'Jessy'];
// $passwords =['paro@123', 'aarohi@234', '123jessi$'];
// duplicate entry will throw error - working
// $passwords =['paro@123'];
// $usernames =['Paromita'];

// associate array to store 'username' => 'new user Id'
$newUserIds = []; 
// enter username and password to db and generate new user id
for($i = 0; $i < count($usernames);$i++){

  $username = $usernames[$i];
  $password = $passwords[$i];

  try{
      $newUserId = Auth::createUser($username, $password);
      // assigning generated newuserId to newuserIds associative array
      $newUserIds[$username] = $newUserId;
  } catch (PDOException $pdoEx) {
    // SQLSTATE 23000 is integrity constraint violation (including duplicates)
       if ($pdoEx->getCode() == '23000' && strpos($pdoEx->getMessage(), 'Duplicate entry') !== false) {
        $newUserIds[$username] = "Duplicate entry not possible for username '$username'.";
    }
  }
  catch(Exception $ex){
     $newUserIds[$username] = "Error: " . $ex->getMessage();
  }
}
// Display the results
echo "<h3>Created Users:</h3><ul>";
foreach ($newUserIds as $username => $id) {
    echo "<li>$username - $id</li>";
}
echo "</ul>";


// TODO: will change this below content during signup -- it will display signup form and handle create user logic
// Config
// $title = "Add User Data";

// // Start output buffering (trap output - don't display it yet)
// ob_start();

// // Include the page-specific template
//   include_once "templates/_aboutUs.html.php";

// // Stop output buffering - store output into the $content variable
// $content = ob_get_clean();

// // Include the layout (e.g., _layout.html.php contains the full HTML structure)
// include_once "templates/_layout.html.php";
?>