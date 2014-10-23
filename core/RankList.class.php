<?php

/**
 * A list containing all available ranks
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class RankList {

   /**
    * Array containing all listed items
    */
   private static $_list = array();


   /**
    * Toggle to indicate first initialization
    */
   private static $_initialized = false;


   /**
    * Creates a new RankList
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
    * Initialies the list (loads data)
    */
   private function _init() {
      global $xDb;

      // Query (selection)
      $query = "SELECT name, rank                                     " .
               "FROM (%s) AS subset                                   " .
               "GROUP BY rank                                         " .
               "ORDER BY rank                                         ";

      // Subquery (translations)
      $trans = "SELECT t1.*                                           " .
               "FROM #__usergroups AS t1                              " .
               "INNER JOIN #__languages AS t2 ON t1.language = t2.iso " .
               "ORDER BY t2.preference, t1.rank                       ";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($dbRow = $stmt->fetchObject()) {
         self::$_list[$dbRow->rank] = $dbRow;
      }

   }


   /**
    * Returns all available ranks
    *
    * @return Array containing Objects with rank information
    */
   public function toArray() {
      return self::$_list;
   }

}
?>