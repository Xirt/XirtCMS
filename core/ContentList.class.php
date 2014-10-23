<?php

/**
 * List containing all available content
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ContentList {

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
    * Creates new ContentList instance
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
      $query = "SELECT xid, category, title    " .
               "FROM (%%s) AS subset           " .
               "GROUP BY xid                   " .
               "ORDER BY title                 ";
      $query = sprintf($query);

      // Subquery (translations)
      $subset = "SELECT t1.*, t2.preference    " .
                "FROM #__content AS t1         " .
                "INNER JOIN #__languages AS t2 " .
                "ON t1.language = t2.iso       " .
                "ORDER BY t2.preference, t1.xid";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $subset));
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($content = $stmt->fetch(PDO::FETCH_OBJ)) {
         self::$_list[] = $content;
      }

   }


   /**
    * Returns a list of available content
    *
    * @param $categorizeContent Toggles categorization of content (default: false)
    * @return Array with all content (optionally grouped by category)
    */
   public function toArray($categorizeContent = false) {

       if ($categorizeContent) {

          $list = array();
          foreach (self::$_list as $content) {

             if (!array_key_exists($content->category, $list)) {
                $list[$content->category] = array();
             }

             $list[$content->category][] = $content;

          }

          return $list;
       }

       return self::$_list;
   }

}
?>