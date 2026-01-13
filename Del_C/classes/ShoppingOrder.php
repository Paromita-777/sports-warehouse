<?php

/**
 * Defines a Shopping Oder (part of the business logic layer)
 */
class ShoppingOrder
{

  #region Properties (private)

  private int $_shoppingOrderId;
  private DateTime $_orderDate;
  private string $_firstName;
  private string $_lastName;
  private string $_address;
  private string $_contactNumber;
  private string $_email;
  private string $_creditCardNumber;
  private string $_expiryDate;
  private string $_nameOnCard;
  private string $_csv;
  private DBAccess $_db;

  #endregion

  #region Constructor - sets up the database connection (using DBAccess)

  /**
   * Create Category instance with database connection
   */
  public function __construct(DBAccess $db)
  {
    $this->_db = $db;
    
    // Set current date and time on object creation
    $this->_orderDate = new DateTime(); 
  }
  

  #endregion

  #region Getter and setter methods

  /**
   * Get Shopping Order Id (there is NO setter for Shopping Order ID to make it read-only)
   *
   * @return int The Shopping Order  ID
   */
  public function getShoppingOrderId(): int
  {
    return $this->_shoppingOrderId;
  }

  /**
   * Get Order Date
   *
   * @return DateTime The order date
   */
  public function getOrderDate(): DateTime
  {
    // Return value of private property
    return $this->_orderDate;
  }

  /**
   * Get first name
   *
   * @return string The First name
   */
  public function getFirstName(): string
  {
    // Return value of private property
    return $this->_firstName;
  }

 /**
   * Set Order Date
   *
   * @param  DateTime $orderDate The  Order Date
   * @return void
   */
  public function setOrderDate(DateTime $orderDate): void
  {
     $this->_orderDate = $orderDate;
  } 

  /**
   * Set Firstname
   *
   * @param  string $firstName The  FastName
   * @return void
   */
  public function setFirstName(string $firstName): void
  {
    // Remove spaces
    $value = trim($firstName);

    // Check string length (between 1 & 50)
    if (strlen($value) < 1 || strlen($value) > 50) {

      // Invalid new value - throw an exception
      throw new Exception("First name must be 1-50 characters.");
    }

    // Store new value in the private property
    $this->_firstName = $value;
  }
  /**
   * Set Last name
   *
   * @param  string $lastName The  Lastname
   * @return void
   */
  public function setLastName(string $lastName): void
  {
    // Remove spaces
    $value = trim($lastName);

    // Check string length (between 1 & 50)
    if (strlen($value) < 1 || strlen($value) > 50) {

      // Invalid new value - throw an exception
      throw new Exception("Last name must be 1-50 characters.");
    }

    // Store new value in the private property
    $this->_lastName = $value;
  }

  /**
   * Set address
   *
   * @param  string $address The  Address
   * @return void
   */
  public function setAddress(string $address): void
  {
    // Remove spaces
    $value = trim($address);

    // Check string length (between 1 & 200)
    if (strlen($value) < 1 || strlen($value) > 200) {

      // Invalid new value - throw an exception
      throw new Exception("address must be 1-200 characters.");
    }

    // Store new value in the private property
    $this->_address = $value;
  }

  /**
   * Set Contact Number
   *
   * @param  string $contactNumber The  Contact Number
   * @return void
   */
  public function setContactNumber(string $contactNumber): void
  {
    // Remove spaces
    $value = trim($contactNumber);

    // Check string length (between 1 & 20)
    if (strlen($value) < 1 || strlen($value) > 20) {

      // Invalid new value - throw an exception
      throw new Exception("Contact Number must be 1-20 characters.");
    }

    // Store new value in the private property
    $this->_contactNumber = $value;
  }

  /**
   * Set Email
   *
   * @param  string $email The  Email
   * @return void
   */
  public function setEmail(string $email): void
  {
    // Remove spaces
    $value = trim($email);

    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
     throw new Exception("Invalid email format.");
    }
    // Store new value in the private property
    $this->_email = $value;
  }

  /**
   * Set Credit Card Number 
   *
   * @param  string $creditCardNumber The Credit Card Number
   * @return void
   */
  public function setcreditCardNumber(string $creditCardNumber): void
  {
    // Remove spaces
    $value = trim($creditCardNumber);

    // Check string length (between 1 & 20)
    if (strlen($value) < 1 || strlen($value) > 20) {

      // Invalid new value - throw an exception
      throw new Exception("Credit Card Number name must be 1-20 characters.");
    }

    // Store new value in the private property
    $this->_creditCardNumber = $value;
  }

  /**
   * Set Expiry Date
   *
   * @param  string $expiryDate The  Expiry Date
   * @return void
   */
  public function setExpiryDate(string $expiryDate): void
  {
    // Remove spaces
    $value = trim($expiryDate);

    // Check string length (between 1 & 10)
    if (strlen($value) < 1 || strlen($value) > 10) {

      // Invalid new value - throw an exception
      throw new Exception("Expiry Date must be 1-10 characters.");
    }

    // Store new value in the private property
    $this->_expiryDate = $value;
  }

  /**
   * Set Name on Card
   *
   * @param  string $nameOnCard The  Name on Card
   * @return void
   */
  public function setNameOnCard(string $nameOnCard): void
  {
    // Remove spaces
    $value = trim($nameOnCard);

    // Check string length (between 1 & 50)
    if (strlen($value) < 1 || strlen($value) > 50) {

      // Invalid new value - throw an exception
      throw new Exception("Name on Card must be 1-50 characters.");
    }

    // Store new value in the private property
    $this->_nameOnCard = $value;
  }

  /**
   * Set CSV
   *
   * @param  string $csv The  CSV
   * @return void
   */
  public function setCsv(string $csv): void
  {
    // Remove spaces
    $value = trim($csv);

    if (!ctype_digit($value)) {
      throw new Exception("CSV must contain only digits.");
    }
    // Store new value in the private property
    $this->_csv = $value;
  }

  #endregion

  #region Methods

  
  /**
   * Inserts customer checkout details into the `shoppingorder` table.
   * 
   * This method assumes that the object's properties (first name, last name, address, etc.)
   * have already been populated and inserts them into the database as a new shopping order record.
   *
   * @return integer The ID of the of the newly inserted shopping order.
   * @throws Exception If an error occurs during database interaction.
   */
  public function insertCustomerDetails(): int
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
        INSERT INTO shoppingorder(
          orderDate,
          firstName, 
          lastName, 
          address, 
          contactNumber, 
          email, 
          creditCardNumber, 
          expiryDate, 
          nameOnCard, 
          csv) 
        VALUES (
          :orderDate,
          :firstName,
          :lastName,
          :address,
          :contactNumber,
          :email,
          :creditCardNumber,
          :expiryDate,
          :nameOnCard,
          :csv)
        SQL;
        $stmt = $this->_db->prepareStatement($sql);
        $stmt->bindValue(":orderDate", $this->_orderDate->format('Y-m-d H:i:s'), PDO::PARAM_STR);
        $stmt->bindValue(":firstName", $this->_firstName, PDO::PARAM_STR);
        $stmt->bindValue(":lastName", $this->_lastName, PDO::PARAM_STR);
        $stmt->bindValue(":address", $this->_address, PDO::PARAM_STR);
        $stmt->bindValue(":contactNumber", $this->_contactNumber, PDO::PARAM_STR);
        $stmt->bindValue(":email", $this->_email, PDO::PARAM_STR);
        $stmt->bindValue(":creditCardNumber", $this->_creditCardNumber, PDO::PARAM_STR);
        $stmt->bindValue(":expiryDate", $this->_expiryDate, PDO::PARAM_STR);
        $stmt->bindValue(":nameOnCard", $this->_nameOnCard, PDO::PARAM_STR);
        $stmt->bindValue(":csv", $this->_csv, PDO::PARAM_STR);

      // Execute query and return new ID
      // true means return the new ID (primary key value)
      return $this->_db->executeNonQuery($stmt, true);
    } catch (Exception $ex) {
      // Log exception details
        error_log("Exception in insertCustomerDetails in shoppingOrder entity: " . $ex->getMessage() . " in " . $ex->getFile() . ":" . $ex->getLine());
        // Re-throw for controller to catch and handle user-friendly messages
        throw $ex;
    }
  }

  #endregion

}
