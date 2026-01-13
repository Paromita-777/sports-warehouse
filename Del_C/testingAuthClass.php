<?php

// Common includes such as class definitions and constants
require_once "includes/common.php";


// 1. checking fetchUserCredentials() 
// try
// { 
// // checked with admin and one usernamae working fine 
//   $username ='admin';
//   $isUserExists = AUTH::fetchUserCredentials($username);
//   if($isUserExists){
//     echo "password:". $isUserExists['password']."role:".$isUserExists['role'];
//   }
//   else{
//     echo"user doesn't exists!";
//   }
// }
// catch (Exception $ex) {

//   // "Handle" exception
//   echo "<p>Catastrophic error: {$ex->getMessage()}</p>";

// }


// // 2. checking login() 
// try
// { 
// // checked with admin and one usernamae working fine 
//   $username ='Paromita.sarkar1';
//   $password ='paro@123';
//   $isUserExists = AUTH::login($username,$password);
//   if($isUserExists){
//     echo "role:".$isUserExists['role'];
//   }
//   else{
//     echo"user doesn't exists!";
//   }
// }
// catch (Exception $ex) {

//   // "Handle" exception
//   echo "<p>Catastrophic error: {$ex->getMessage()}</p>";

// }

// 3. doesUserExistAndPasswordMatch() 
try
{ 
// checked with admin and one usernamae working fine 
  $username ='Paro';
  $password ='password';
  $isUserExists = AUTH::doesUserExistAndPasswordMatch($username,$password);
  if($isUserExists){
    echo "user exists!";
  }
  else{
    echo"user doesn't exists!";
  }
}
catch (Exception $ex) {

  // "Handle" exception
  echo "<p>Catastrophic error: {$ex->getMessage()}</p>";

}