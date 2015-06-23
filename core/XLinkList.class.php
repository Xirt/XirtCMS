<?php

/**
 * Database Class for storing XLinks
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XLinkList {

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

      if ((!self::$_initialized || $forceRefresh) && XConfig::get("SEO_LINKS")) {
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
      $query = "SELECT cid, iso, query, alternative FROM #__links";

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Create list
      self::$_list = array();
      while  ($dbRow = $stmt->fetchObject()) {

         self::$_list[] = new XLink(
            $dbRow->query,
            $dbRow->alternative,
            $dbRow->cid,
            $dbRow->iso
         );

      }

   }


   /**
    * Adds a link to the list (if not already existing)
    *
    * @param $link The XLink to add to the list
    */
   function add($item) {

      // Prevent duplicate items
      if ($this->returnLinkByQuery($item->query, $item->iso)) {
         return false;
      }

      return (self::$_list[] = $item) && $item->save();
   }


   /**
    * Returns XLink by SEF variant (String)
    *
    * @param $link String with the searched SEF variant of the link
    * @return mixed The original XLink on success, null otherwise
    */
   public function returnLinkByAlternative($str) {

      foreach (self::$_list as $candidate) {

         if ($candidate->alternative == $str) {
            return $candidate;
         }

      }

      return null;
   }


   /**
    * Returns XLink by original query (String)
    *
    * @param $str String with the original link (query)
    * @return mixed The original XLink on success, null otherwise
    */
   public function returnLinkByQuery($str, $iso = null) {

      foreach (self::$_list as $candidate) {

         if ($candidate->query == $str && (!$iso || $candidate->iso == $iso)) {
            return $candidate;
         }

      }

      return null;
   }

}
?>