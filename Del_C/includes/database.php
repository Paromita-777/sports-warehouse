<?php

  // Dependencies
  require_once ROOT_DIR . "classes/DBAccess.php";

  // Check if website is running locally (localhost, 127.0.0.1, ::1)
  if (
    $_SERVER["SERVER_NAME"] === "localhost" ||
    $_SERVER["SERVER_ADDR"] === "127.0.0.1" ||
    $_SERVER["SERVER_ADDR"] === "::1"
  ) {

    // Database config - local
    $dbServer = "localhost";
    $dbDatabase = "sportswarehouse";
    $dbUsername = "root";
    $dbPassword = "";

  } else {

    // Database config - remote
    $dbServer = "localhost";
    $dbDatabase = "navy20_sportswarehouse";
    $dbUsername = "navy20_sportswarehouse";
    $dbPassword = REMOTE_DB_PASSWORD;  // Loading from secrets.php

  }

  // Create a new DBAccess instance (this is used for ALL database operations!)
  $db = new DBAccess($dbServer, $dbDatabase, $dbUsername, $dbPassword);