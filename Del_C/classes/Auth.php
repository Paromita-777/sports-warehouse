<?php

/**
 * The Auth class handles authentication and authorisation tasks such as logging in, logging out, checking if user is logged in, etc. This class is designed to be used statically (without creating an instance), e.g. Auth::protect()
 * 
 * __Auth::LOGIN_PAGE_URL__ - The relative URL of the login page, e.g. login.php
 * 
 * __Auth::SUCCESS_PAGE_URL__ - The relative URL of the success page (redirected after login), e.g. protected.php
 * 
 * __Auth::createUser($username, $password)__ - Create a new user in the database with an optional role, returns their ID.
 * 
 * __Auth::login($username, $password)__ - Login using the supplied username and password.
 * On success, user is redirected to SUCCESS_PAGE_URL, otherwise returns false.
 * 
 * __Auth::logout()__ - Logout. Session is forgotten, user is redirected to LOGIN_PAGE_URL.
 * 
 * __Auth::protect()__ - Protect a page against unauthorised access (users that are not logged in).
 * If a user is not logged in, they will be redirected to LOGIN_PAGE_URL.
 * 
 * __Auth::isLoggedIn()__ - Check if a user is currently logged in.
 * 
 * __Auth::doesUserExistAndPasswordMatch()__ - Check if a user exists in the database and if the provided password matches returns true else false.
 * 
 * __Auth::updateUserPassword()__ -  This function hashes the new given password and updates it in the database for the given username. 
 * 
 */
class Auth
{
	#region Properties

	// Settings defined as constants (unchanging values)
	/** @var string The relative URL of the login page, e.g. login.php */
	const LOGIN_PAGE_URL = "loginForm.php";

	/** @var string The relative URL of the success page (redirected after login), e.g. protected.php */
	const SUCCESS_PAGE_URL = "authRedirect.php";

	private static $_db;

	#endregion

	#region Methods

		
	/**
	 * Opens a connection to the database. DBAccess instance stored in self::$_db
	 *
	 * @return void
	 */
	private static function openDatabaseConnection()
	{
		try
		{	
			// Check if no existing DBAccess instance
			if (is_null(self::$_db)) {

				// Create database connection and store into _db property so other methods can use DBAccess
				require "includes/database.php";
				self::$_db = $db;
			}

			// Open connection
			self::$_db->connect();
			
		}
		catch (PDOException $e)
		{
			die("Unable to connect to database, ". $e->getMessage());
		}
	}

		
	/**
	 * Start session if it's not already started.
	 *
	 * @return void
	 */
	private static function sessionStart()
	{
		// Start session (if it's not already started)
		if (!isset($_SESSION)){
			session_start();
		}
	}


	/**
	 * Create a new user in the database.
	 *
	 * @param  string $username The user's username.
	 * @param  string $password The user's plaintext (unhashed) password.
	 * @param  string $role The user's role (optional,default to 'user'.)
	 * @return int The new user's ID.
	 */
	public static function createUser($username, $password, $role ='user') 
	{
		// Hash the password (using PHP default suggested hashing algorithm and settings)
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		// Open database connection
		// NOTE: static methods are called using self::method() instead of $this->method()
		self::openDatabaseConnection();

		// Add user to the database
		try
		{
			// Define SQL query, prepare statement, bind parameters
			$sql = <<<SQL
				INSERT INTO user 	(userName, password, role)
				VALUES 						(:username, :password, :role)
			SQL;
			$stmt = self::$_db->prepareStatement($sql);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);
			$stmt->bindParam(":role", $role, PDO::PARAM_STR);

			// Execute query
			$newUserId = self::$_db->executeNonQuery($stmt, true);

			// Check for bad result from INSERT
			if ($newUserId === false) {
				throw new Exception("Error adding user to database.");
			}

		}
		catch (PDOException $e)
		{
			throw $e;
		}

		// Return new user's ID
		return $newUserId;
	}
	/**
	 * Fetch user credentials(password and role) from the database using the supplied username. 
	 * Returns an associative array if found, or false if the user doesn't exist.
	 * 
	 * @param  string $username The user's username.
	 * @return  array|false Associative array with 'password' and 'role', or false if not found.
	 */
	public static function fetchUserCredentials($username)
	{
		// Make sure session is started
		self::sessionStart();

		// Open database connection
		self::openDatabaseConnection();

		// Get user's details from the database (if they exist)
		try
		{
			// Define SQL query, prepare statement, bind parameters
			$sql = <<<SQL
				SELECT 	password, role 
				FROM 		user
				WHERE		userName = :username
			SQL;
			$stmt = self::$_db->prepareStatement($sql);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);

			//execute the query and return the row 
			$user = self:: $_db->executeSQLReturnOneRow($stmt);
			return $user ?: false;
		}
		catch (PDOException $e)
		{
			throw $e;
		}
	}
/**
	 * Login using the supplied username and password. On success, user is redirected to SUCCESS_PAGE_URL, otherwise returns false.
	 *
	 * @param  string $username The user's username.
	 * @param  string $password The user's plaintext (unhashed) password.
	 * @return bool	False if login credentials are not valid, otherwise redirected to SUCCESS_PAGE_URL.
	 */
	public static function login($username, $password)
	{
		// Make sure session is started
		self::sessionStart();

		// Open database connection
		self::openDatabaseConnection();

		$hashedPassword = '';

		// Get user's password from the database (if they exist)
		try
		{
			// Get user details(password and role) if user exists
			$userDetails = self::fetchUserCredentials($username);
			if (!$userDetails) {
				return false;
			}
			$hashedPassword = $userDetails['password'];
		}
		catch (PDOException $e)
		{
			throw $e;
		}

		// If user exists, check if the password matches
		if($hashedPassword && password_verify($password, $hashedPassword)) {

			// ✔ Success! Store the username into the session data (as proof they're logged in)
			$_SESSION["username"] = $username;
			// store role as well 
			$_SESSION['role'] = $userDetails['role'];

			// Redirect the user to the success page (change header and exit)
			header("Location: " . self::SUCCESS_PAGE_URL);
			exit;

		}
		
		// Invalid login credentials
		return false;
	}

	// TODO: mike's code will delete this login method if new login mentioned above works
	// /**
	//  * Login using the supplied username and password. On success, user is redirected to SUCCESS_PAGE_URL, otherwise returns false.
	//  *
	//  * @param  string $username The user's username.
	//  * @param  string $password The user's plaintext (unhashed) password.
	//  * @return bool	False if login credentials are not valid, otherwise redirected to SUCCESS_PAGE_URL.
	//  */
	// public static function login($username, $password)
	// {
	// 	// Make sure session is started
	// 	self::sessionStart();

	// 	// Where the user's hashed password will be stored after retrieval from the database
	// 	$hashedPassword = "";

	// 	// Open database connection
	// 	// NOTE: static methods are called using self::method() instead of $this->method()
	// 	self::openDatabaseConnection();

	// 	// Get user's password from the database (if they exist)
	// 	try
	// 	{
	// 		// Define SQL query, prepare statement, bind parameters
	// 		$sql = <<<SQL
	// 			SELECT 	password, role 
	// 			FROM 		user
	// 			WHERE		userName = :username
	// 		SQL;
	// 		$stmt = self::$_db->prepareStatement($sql);
	// 		$stmt->bindParam(":username", $username, PDO::PARAM_STR);

	// 		// Execute query - get hashed password
	// 		// $hashedPassword = self::$_db->executeSQLReturnOneValue($stmt);
	// 		$user = self:: $_db->executeSQLReturnOneRow($stmt);
	// 		$hashedPassword = $user['password'];
	// 	}
	// 	catch (PDOException $e)
	// 	{
	// 		throw $e;
	// 	}

	// 	// If user exists, check if the password matches
	// 	if($hashedPassword && password_verify($password, $hashedPassword)) {

	// 		// ✔ Success! Store the username into the session data (as proof they're logged in)
	// 		$_SESSION["username"] = $username;
	// 		// store role as well 
	// 		$_SESSION['role'] = $user['role'];

	// 		// Redirect the user to the success page (change header and exit)
	// 		header("Location: " . self::SUCCESS_PAGE_URL);
	// 		exit;

	// 	}
		
	// 	// Invalid login credentials
	// 	return false;
	// }

	
	/**
	 * Logout. Session is forgotten, user is redirected to LOGIN_PAGE_URL.
	 *
	 * @return void
	 */
	public static function logout()
	{
		// Make sure session is started
		self::sessionStart();

		// Remove session data for the user (username and role)
		unset($_SESSION['username'],$_SESSION['role']);

		// Optionally redirect the user to the login page after logout
		// header("Location: " . self::LOGIN_PAGE_URL);
		// exit;
	}

	
	/**
	 * Protect a page against unauthorised access (users that are not logged in). If a user is not logged in, they will be redirected to LOGIN_PAGE_URL.
	 *
	 * @return void
	 */
	public static function protect()
	{
		// Make sure session is started
		self::sessionStart();

		if (empty($_SESSION["username"])) {

			// Redirect the user to the login page
			header("Location: " . self::LOGIN_PAGE_URL);
			exit;
		}
	}


	
	/**
	 * Check if a user is currently logged in.
	 *
	 * @return bool True if logged in, otherwise false.
	 */
	public static function isLoggedIn()
	{
		// Make sure session is started
		self::sessionStart();

		// Check if "username" is stored in session
		return !empty($_SESSION["username"]);
	}


	
/**
 * Check if a user exists in the database and if the provided password matches.
 *
 * This function first checks if a user with the provided username exists.
 * If the user is found, it verifies the supplied plaintext password against the hashed password stored in the database.
 *
 * @param  string $username The user's username.
 * @param  string $password The user's plaintext (unhashed) password.
 * @return bool True if user exists and password matches, otherwise false.
 */
	public static function doesUserExistAndPasswordMatch($username, $password)
	{
		// Make sure session is started
		self::sessionStart();

		// Where the user's hashed password will be stored after retrieval from the database
		$hashedPassword = "";

		// Open database connection
		self::openDatabaseConnection();

		// Get user's password from the database (if they exist)
		try
		{
			// get user details from database if the given usesrname exists
			$userDetails = self::fetchUserCredentials($username);

			// If user doesn't exist returns false
			if (!$userDetails) {
    		return false;
			}
			
			// Get the hashedpassword from the associative array
			$hashedPassword = $userDetails['password'];

			// If password found and matches
			if($hashedPassword && password_verify($password, $hashedPassword)) {
				// ✔ Success! 
				return true; 
			}
		}
		catch (PDOException $e)
		{
			throw $e;
		}
	
		// Either user not found or password incorrect
		return false;
	}

/**
 * Update the user's password and stores it in the database.
 *
 * This function hashes the new password and updates it in the database for the given username. 
 * 
 * @param  string $username The user's username.
 * @param  string $password The user's plaintext (unhashed) password.
 * @return bool True if password update was successful, otherwise false.
 */
	public static function updateUserPassword($username, $password)
	{
		// Make sure session is started
		self::sessionStart();
		
		// Hash the password (using PHP default suggested hashing algorithm and settings)
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

		// Open database connection
		self::openDatabaseConnection();	

		try
		{
			// Prepare SQL update query
			$sql = <<<SQL
				UPDATE user
				SET password = :password
				WHERE userName = :username
			SQL;

			$stmt = self::$_db->prepareStatement($sql);
			$stmt->bindParam(":username", $username, PDO::PARAM_STR);
			$stmt->bindParam(":password", $hashedPassword, PDO::PARAM_STR);

			// Execute and return success/failure
        return self::$_db->executeNonQuery($stmt);
			}catch (PDOException $e){
				throw $e;
			}
}
		
	#endregion
	
}