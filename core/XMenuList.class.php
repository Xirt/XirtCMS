<?php

/**
 * List containing all available menus
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XMenuList {

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
    * Creates new MenuList instance
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

      // Query (selection)
      $query = "SELECT *                                              " .
               "FROM (%s) AS subset                                   " .
               "GROUP BY xid                                          " .
               "ORDER BY ordering ASC                                 ";

      // Subquery (translations)
      $trans = "SELECT t1.*                                           " .
               "FROM #__menus AS t1                                   " .
               "INNER JOIN #__languages AS t2 ON t1.language = t2.iso " .
               "ORDER BY t2.preference, t1.ordering                   ";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($menu = $stmt->fetch(PDO::FETCH_OBJ)) {

         self::$_list[] = new XMenu(
            $menu->xid,
            $menu->title,
            $menu->language,
            $menu->sitemap
         );

      }

   }


   /**
    * Returns a filtered list of available modules
    *
    * @return Array with details on all menus
    */
   public function toArray() {
       return self::$_list;
   }

}
?>