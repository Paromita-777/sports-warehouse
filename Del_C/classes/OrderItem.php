<?php

/**
 * Defines a Order Item (part of the business logic layer)
 */
class OrderItem
{

  #region Properties (private)

  private int $_itemId;
  private int $_shoppingOrderId;
  private int $_quantity;
  private float $_price;
  private DBAccess $_db;

  #endregion

  #region Constructor - sets up the database connection (using DBAccess)

  /**
   * Create Category instance with database connection
   */
  public function __construct(DBAccess $db)
  {
    $this->_db = $db;
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
   * Set Shopping Order ID
   *
   * @param  int  $shoppingOrderID The Shopping order Id 
   * @return void
   */
  public function setShoppingOrderId(int $shoppingOrderID): void
  {
     $this->_shoppingOrderId = $shoppingOrderID;
  } 


 /**
   * Set Item Id
   *
   * @param  int  $itemId The Item Id 
   * @return void
   */
  public function setItemId(int $itemId): void
  {
     $this->_itemId = $itemId;
  }   

 /**
   * Set item quantity
   *
   * @param  int  $quantity The Quantity of the item 
   * @return void
   */
  public function setQuantity(int $quantity): void
  {
     $this->_quantity = $quantity;
  } 

  /**
   * Set Price
   *
   * @param  float  $price The Price 
   * @return void
   */
  public function setPrice(float $price): void
  {
     $this->_price = $price;
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
  public function insertOrderDetails(int $itemId, int $shoppingOrderId, int $quantity, float $price): bool
  {
    try {

        $this->_itemId = $itemId;
        $this->_shoppingOrderId = $shoppingOrderId;
        $this->_quantity = $quantity;
        $this->_price = $price;

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
        INSERT INTO orderitem(
          itemId, 
          shoppingOrderId,
          quantity,
          price) 
          VALUES (
            :itemId,
            :shoppingOrderId,
            :quantity,
            :price)
        SQL;

        $stmt = $this->_db->prepareStatement($sql);
        $stmt->bindValue(":itemId", $this->_itemId, PDO::PARAM_INT);
        $stmt->bindValue(":shoppingOrderId", $this->_shoppingOrderId, PDO::PARAM_INT);
        $stmt->bindValue(":quantity", $this->_quantity, PDO::PARAM_INT);
        $stmt->bindValue(":price", $this->_price, PDO::PARAM_STR);
      
      return $this->_db->executeNonQueryBoolean($stmt);
    } catch (Exception $ex) {
      // Log exception details
        error_log("Failed to insert order item: " . $ex->getMessage());
        return false;
    }
  }


  #endregion

}
