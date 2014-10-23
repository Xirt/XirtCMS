<?php

/**
 * A list containing all available languages
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LanguageList {

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
    * Creates a new LanguageList
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

      // Database query
      if (defined('_ADMIN')) {

         $query = 'SELECT *            ' .
                  'FROM #__languages      ' .
                  'ORDER BY preference ASC';

      } else {

         $query = 'SELECT *               ' .
                  'FROM #__languages      ' .
                  'WHERE published = 1    ' .
                  'ORDER BY preference ASC';

      }

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($dbRow = $stmt->fetchObject()) {
         self::$_list[$dbRow->iso] = $dbRow;
      }

   }


   /**
    * Returns all available languages
    *
    * @param $currentOnTop If true, the current language will be the first item
    * @return Array containing instances of Language
    */
   public function toArray($currentOnTop = false) {

      // Place current language on top (optional)
      if ($currentOnTop && array_key_exists(XConfig::getLanguage(), self::$_list)) {

         $current = self::$_list[XConfig::get("SESSION_LANGUAGE")];
         $current = array($current->iso => $current);
         self::$_list = $current + self::$_list;

      }

      return self::$_list;
   }

}
?>