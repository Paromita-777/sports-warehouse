<?php

/**
 * Defines a Item (part of the business logic layer)
 */
class Item
{

  #region Properties (private)
  /**
   * @var int Item ID (Primary Key)
   */
  private int $_itemId;

  /**
   * @var string Item name (max 150 chars)
   */
  private string $_itemName;

  /**
   * @var string|null Photo path (nullable, max 250 chars)
   */
  private ?string $_photo = null;

  /**
   * @var float Price (decimal 10,2)
   */
  private float $_price;

  /**
   * @var float|null Sale price (nullable decimal 10,2)
   */
  private ?float $_salePrice = NULL;

  /**
   * @var string|null Description (nullable, max 2000 chars)
   */
  private ?string $_description = NULL;

  /**
   * @var bool Featured (tinyint(1))
   */
  private bool $_featured;

  /**
   * @var int Category Id 
   */
  private int $_categoryId;

  private DBAccess $_db;

  #endregion

  #region Constructor - sets up the database connection (using DBAccess)

  /**
   * Create Item instance with database connection
   */
  public function __construct(DBAccess $db)
  {
    $this->_db = $db;
  }

  #endregion

  #region Getter and setter methods
 /**
   * Set item id
   *
   * @param string $id The item id
   */
  public function setItemId(int $id): void
  {
    $this->_itemId = $id;
  }

  /**
   * Set item name
   *
   * @param string $name The item name
   */
  public function setItemName(string $name): void
  {
    $this->_itemName = $name;
  }

  /**
   * Set photo path
   *
   * @param string|null $photo The photo path (nullable)
   */
  public function setItemPhoto(?string $photo): void 
  {
    $this->_photo = $photo ?? '';
  }

  /**
   * Set price
   *
   * @param float $price The item price
   */
  public function setItemPrice(float $price): void
  {
    $this->_price = $price;
  }

  /**
   * Set sale price
   *
   * @param float|null $salePrice The sale price (nullable)
   */
  public function setItemSalePrice(?float $salePrice): void
  {
    $this->_salePrice = $salePrice;
  }

  /**
   * Set description
   *
   * @param string|null $description The description (nullable)
   */
  public function setItemDescription(?string $description): void
  {
    $this->_description = $description;
  }

  /**
   * Set featured status
   *
   * @param bool $featured Whether the item is featured
   */
  public function setItemFeatured(bool $featured): void
  {
    $this->_featured = $featured;
  }

  /**
   * Set category ID
   *
   * @param int $categoryId The category ID
   */
  public function setItemCategoryId(int $categoryId): void
  {
    $this->_categoryId = $categoryId;
  }


  /**
   * Get item ID (there is NO setter for item ID to make it read-only)
   *
   * @return int The item ID
   */
  public function getItemId(): int
  {
    return $this->_itemId;
  }

  /**
   * Get item name
   *
   * @return string The item name
   */
  public function getItemName(): string
  {
    // Return value of private property
    return $this->_itemName;
  }
  /**
   * Get photo
   *
   * @return string|null The photo 
   */
  public function getPhoto(): ?string
  {
    // Return value of private property
    return $this->_photo;
  }
  /**
   * Get price
   *
   * @return float The price
   */
  public function getPrice(): float
  {
    // Return value of private property
    return $this->_price;
  }
  /**
   * Get sale price
   *
   * @return float|null The sale price or null if not set
   */
  public function getSalePrice(): ?float
  {
    // Return value of private property
    return $this->_salePrice;
  }
  /**
   * Get description
   *
   * @return string|null The description
   */
  public function getDescription(): ?string
  {
    // Return value of private property
    return $this->_description;
  }
  /**
   * Get featured status
   *
   * @return bool The featured status 
   */
  public function isFeatured(): bool
  {
    // Return value of private property
    return $this->_featured;
  }
  /**
   * Get item category Id
   *
   * @return string The categoryId 
   */
  public function getCategoryId(): int
  {
    return $this->_categoryId;
  }

  /**
   * Get all items 
   *
   * @return array The collection of items
   */
  public function getItems(): array
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
       SELECT itemId,itemName, photo, price, salePrice, description, featured,i.categoryId, c.categoryName
      FROM item i
      LEFT JOIN category c ON c.categoryId = i.categoryId
      SQL;
      // prepare statement
      $stmt = $this->_db->prepareStatement($sql);

      // Get data from database and return as an array of rows
      return $this->_db->executeSQL($stmt);
    } catch (Exception $ex) {

      // Throw the exception back up a level (don't handle it here - this is not the UI)
      throw $ex;
    }
  }

  /**
   * Load item by item ID and populate the object's properties
   *
   * @param  int $id The ID of the item to get
   * @return void
   */
  public function getItemByItemId(int $id): void
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters

      $sql = <<<SQL
          SELECT itemId, photo, salePrice, price, itemName, description, c.categoryName
          FROM item i
          LEFT JOIN category c ON c.categoryId = i.categoryId
          WHERE i. itemId = :itemId
      SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $id, PDO::PARAM_INT);

      // Get data from database
      $rows = $this->_db->executeSQL($stmt);

      // Check if data found
      if (count($rows) === 0) {

        // Item not found

        // Option 1: Set default values to properties (stay silent)

        // Option 2: Throw exception (not found)
        throw new Exception("Product with ID '{$id}' not found");
      } else {

        // Product found

        // Get the first (and only) row of data - we are searching using the primary key
        $row = $rows[0];

        // Populate properties with data from database
        $this->_itemId = $row['itemId'];
        $this->_itemName = $row['itemName'];
        $this->_photo = $row['photo'];
        $this->_price = $row['price'];
        $this->_salePrice = $row['salePrice'];
        $this->_description = $row['description'];
        // $this->_categoryName = $row['categoryName'];
      }
    } catch (Exception $ex) {

      // Throw the exception back up a level (don't handle it here - this is not the UI)
      throw $ex;
    }
  }
   /**
   * Load item by item ID and populate the object's properties
   *
   * @param  int $id The ID of the item to get
   * @return void
   */
  public function getItemByItemIdReturnsArray(int $id): array
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters

      $sql = <<<SQL
          SELECT itemId, photo, salePrice, price, itemName, description, featured, i.categoryId,c.categoryName
          FROM item i
          LEFT JOIN category c ON c.categoryId = i.categoryId
          WHERE i. itemId = :itemId
      SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $id, PDO::PARAM_INT);

      // Get data from database
      $rows = $this->_db->executeSQL($stmt);

      // Check if data found
      if (count($rows) === 0) {

        // Item not found

        // Option 1: Set default values to properties (stay silent)

        // Option 2: Throw exception (not found)
        throw new Exception("Product with ID '{$id}' not found");
      } else {

        // Product found
         return $rows[0];
      }
    } catch (Exception $ex) {

      // Throw the exception back up a level (don't handle it here - this is not the UI)
      throw $ex;
    }
  }

  /**
   * Get all featured items from the database
   *
   * @return array An array of associative arrays containing featured item details
   */
  public function getfeaturedItems(): array
  {
    try {
      // connect to database
      $this->_db->connect();

      // define SQL query to fetch all  featured items

      $sql = <<<SQL
            SELECT itemId, itemName, photo, price, salePrice, description, c.categoryName
            FROM item i
            LEFT JOIN category c ON c.categoryId = i.categoryId
            WHERE i.featured = 1
        SQL;

      // Prepare statement
      $stmt = $this->_db->prepareStatement($sql);

      // Get the data from the database and  return all rows
      return $this->_db->executeSQL($stmt);
    } catch (Exception $ex) {

      // Throw the exception back up a level (don't handle it here - this is not the UI)
      throw $ex;
    }
  }

  /**
   * Load item by CategoryId and populate the object's properties
   *
   * @param  int $id The ID of the category to get
   * @return void
   */
  // TODO: will change this return type and will populate obj properties 
  public function getItemByCategoryId(int $id): array
  {

    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
          SELECT itemId, photo, salePrice, price, itemName,description, featured, i.categoryId, c.categoryName
          FROM item i
          LEFT JOIN  category c ON c.categoryId = i.categoryId
          WHERE i.categoryId = :categoryId
          LIMIT   0, 5
        SQL;

      // Prepare the statement
      $stmt = $this->_db->prepareStatement($sql);

      // Bind categoryId to the sql statement
      $stmt->bindValue(":categoryId", $id, PDO::PARAM_INT);

      // Get data from database
      $rows = $this->_db->executeSQL($stmt);

      // Check if data found
      if (count($rows) === 0) {

        // Item not found - Throw exception (not found)
        throw new Exception("No items found with categoryId - {$id}.");
      } else {

        return $rows;
        // TODO: will try to return objects later.
        // // Populate properties with data from database
        //     $this->_itemId = $row['itemId'];  
        //     $this->_itemName = $row['itemName'];
        //     $this->_photo = $row['photo'];
        //     $this->_price = $row['price'];
        //     $this->_salePrice = $row['salePrice'];
        //     $this->_description = $row['description'];
        //     $this->_featured = $row['featured'];
        //     $this->_categoryId = $row['categoryId'];

        // TODO: Define and assign _categoryName before using it
        // $this->_categoryName = $row['categoryName'];
      }
    } catch (Exception $ex) {

      // Throw the exception back up a level (don't handle it here - this is not the UI)
      throw $ex;
    }
  }


  /**
   * Search for items by a partial match on item name or category name
   *
   *@param string $searchTerm The partial string to search
   *@return array An array of matched items
   *@throws Exception If a database error occurs
   */
  public function searchItems(string $searchTerm): array
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Add wildcards for partial match
      $term = '%' . strtolower($searchTerm) . '%';

      // First query: search by categoryName
      $sqlCategoryName = <<<SQL
            SELECT i.itemId, i.photo, i.salePrice, i.price, i.itemName, c.categoryName
            FROM item i
            LEFT JOIN category c ON c.categoryId = i.categoryId
            WHERE LOWER(c.categoryName) LIKE LOWER(:searchTerm)
            LIMIT 5
            SQL;

      $stmt1 = $this->_db->prepareStatement($sqlCategoryName);
      $stmt1->bindValue(':searchTerm', $term, PDO::PARAM_STR);
      $results = $this->_db->executeSQL($stmt1);

      // If no results found from categoryName, fallback to itemName
      if (count($results) === 0) {
        $sqlItemName = <<<SQL
            SELECT i.itemId, i.photo, i.salePrice, i.price, i.itemName, c.categoryName
            FROM item i
            LEFT JOIN category c ON c.categoryId = i.categoryId
            WHERE LOWER(i.itemName) LIKE LOWER(:searchTerm)
            LIMIT 5
            SQL;

        $stmt2 = $this->_db->prepareStatement($sqlItemName);
        $stmt2->bindValue(':searchTerm', $term, PDO::PARAM_STR);
        $results = $this->_db->executeSQL($stmt2);
      }

      if (count($results) === 0) {
        throw new Exception("No matching items found.");
      }

      return $results;
    } catch (Exception $ex) {
      throw $ex;
    }
  }


  /**
   * Add an item using values in object's properties
   *
   * @return integer The ID of the new item
   */
  public function insertItem(): int
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Insert item into database
      $sql = <<<SQL
          INSERT INTO item (itemName, photo, price, salePrice, description, featured, categoryId)
          VALUES (:itemName, :photo, :price, :salePrice, :description, :featured, :categoryId)
        SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemName", $this->_itemName, PDO::PARAM_STR);
      $stmt->bindValue(":photo", $this->_photo, PDO::PARAM_STR);
      $stmt->bindValue(":price", $this->_price, PDO::PARAM_STR);
      $stmt->bindValue(":salePrice", $this->_salePrice, PDO::PARAM_STR);
      $stmt->bindValue(":description", $this->_description, PDO::PARAM_STR);
      $stmt->bindValue(":featured", $this->_featured, PDO::PARAM_BOOL);
      $stmt->bindValue(":categoryId", $this->_categoryId,PDO::PARAM_INT);

      // Return new item ID
      return $this->_db->executeNonQuery($stmt, true);
    } catch (Exception $ex) {
      throw $ex;
    }
  }
  /**
   * Update an item using values in object's properties
   *
   * @param integer $id The current ID of the item to update
   * @return bool True if update successful
   */
  public function updateItem(int $id): bool
  {
    try {

      // NODO: Add validation to make sure data is OK before inserting into database

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
          UPDATE item 
          SET itemName = :itemName,
              photo = :photo, 
              price = :price, 
              salePrice = :salePrice, 
              description = :description, 
              featured = :featured, 
              categoryId = :categoryId 
              WHERE itemId = :itemId
          SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $id, PDO::PARAM_INT);
      $stmt->bindValue(":itemName", $this->_itemName, PDO::PARAM_STR);
      $stmt->bindValue(":photo", $this->_photo, PDO::PARAM_STR);
      $stmt->bindValue(":price", $this->_price, PDO::PARAM_STR);
      $stmt->bindValue(":salePrice", $this->_salePrice, PDO::PARAM_STR);
      $stmt->bindValue(":description", $this->_description, PDO::PARAM_STR);
      $stmt->bindValue(":featured", $this->_featured, PDO::PARAM_BOOL);
      $stmt->bindValue(":categoryId", $this->_categoryId, PDO::PARAM_INT);

      // Execute query and return success value (true/false)
      return $this->_db->executeNonQuery($stmt);
    } catch (Exception $ex) {
      throw $ex;
    }
  }
  /**
   * Delete an item by ID
   *
   * @param integer $id The ID of the item to delete
   * @return bool True if delete successful
   */
  public function deleteItem(int $id): bool
  {
    try {

      // Open the database connection
      $this->_db->connect();

      // Define query, prepare statement, bind parameters
      $sql = <<<SQL
       DELETE
       FROM item 
       WHERE itemId = :itemId
      SQL;

      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $id, PDO::PARAM_INT);

      // Execute query and return success value (true/false)
      return $this->_db->executeNonQuery($stmt);
    } catch (Exception $ex) {
      throw $ex;
    }
  }



  /**
   * Get the total number of items (COUNT)
   *
   * @return int The number of items
   */
  public function getNumberOfItems(): int
  {
    try {

      // Open database connection
      $this->_db->connect();

      // Define SQL query, prepare statement, bind parameters
      $sql = <<<SQL
        SELECT  COUNT(*)
        FROM    item
      SQL;
      $stmt = $this->_db->prepareStatement($sql);

      // Execute SQL
      $value = $this->_db->executeSQLReturnOneValue($stmt);
      return $value;
    } catch (PDOException $e) {
      throw $e;
    }
  }
   /**
 * Check if a item has any linked items in the orderitem table
 *
 * @param integer $itemID The ID of the item to check
 * @return bool True if the item has one or more linked items, false otherwise
 * @throws Exception If a database error occurs
 */
public function hasLinkedItems(int $id): bool
{
    try {
       // Open the database connection
        $this->_db->connect();

        // Define query, prepare statement, bind parameters
        $sql = <<<SQL
        SELECT COUNT(*) AS itemCount 
        FROM orderitem 
        WHERE itemId = :itemId
        SQL;
      $stmt = $this->_db->prepareStatement($sql);
      $stmt->bindValue(":itemId", $id, PDO::PARAM_INT);

      // Execute query 
       $rows = $this->_db->executeSQL($stmt);
       return count($rows) > 0 && intval($rows[0]['itemCount']) > 0;
    } catch (Exception $ex) {
        throw $ex;
    }
}

  #endregion

}
