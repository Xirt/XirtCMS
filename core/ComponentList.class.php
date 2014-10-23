<?php

/**
 * List containing all available components
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ComponentList {

   /**
    * Internal list containing all items
    * @var Array
    */
   private static $_list = array();


   /**
    * Toggle indicating first initialization
    * @var boolean
    */
   private static $_initialized = false;


   /**
    * Creates new ComponentList instance
    *
    * @param $forceRefresh Toggles a refresh even if data was cached (default: false)
    */
   public function __construct($forceRefresh = false) {

      if (!self::$_initialized || $forceRefresh) {
         $this->_init();
      }

      self::$_initialized = true;
   }


   /**
    * Initializes list (loads data)
    */
   private function _init() {
      global $xDb;

      // Database query
      $query = "SELECT *          " .
               "FROM #__components";

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($dbRow = $stmt->fetchObject()) {
         self::$_list[$dbRow->type] = $dbRow;
      }

   }


   /**
    * Returns all available components
    *
    * @return Array with contents of this instance
    */
   public function toArray() {
      return self::$_list;
   }

}
?>