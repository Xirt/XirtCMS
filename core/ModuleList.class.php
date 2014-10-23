<?php

/**
 * List containing all available modules
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ModuleList {

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
    * Creates new ModuleList instance
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
      global $xDb, $xUser;

      // Database query
      $query = "SELECT *                         " .
               "FROM #__modules                  " .
               "WHERE published = 1              " .
               "  AND access_min <= :rank        " .
               "  AND access_max >= :rank        " .
               "ORDER BY published DESC, ordering";

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(":rank", $xUser->rank, PDO::PARAM_INT);
      $stmt->execute();

      // Create list
      self::$_list = array();
      while ($module = $stmt->fetch(PDO::FETCH_OBJ)) {
         self::$_list[$module->position][$module->language][$module->type][$module->xid] = $module;
      }

   }


   /**
    * Returns a filtered list of available modules
    *
    * @param $filters The filters that must be applied (e.g. language, position, type)
    * @param $currentPageOnly Toggles filtering based on current request vs. all pages
    * @return Array with modules for given position / language
    */
   public function toArray($filters = array(), $currentPageOnly = true) {

       $list = array(self::$_list);

       // Applies all given filters
       $list = $this->_filter($list, $filters, "POSITION");
       $list = $this->_filter($list, $filters, "LANGUAGE");
       $list = $this->_filter($list, $filters, "MOD_TYPE");
       $list = $this->_filter($list, $filters, "MOD_ID");

       // Apply optional page filtering
       if ($currentPageOnly && count($list)) {
          return $this->_pageFilter($list);
       }

       return $list;
   }


   /**
    * Attempt to apply a filter to the given list
    *
    * @param $list The list to be filtered
    * @param $filters All filters that were requested for this list
    * @param $type The type of filter to apply
    * @return The filtered list
    */
   private function _filter($list, $filters, $type) {

      $returnList = array();
      foreach ($list as $currentList) {

         if (array_key_exists($type, $filters) && $type = $filters[$type]) {

            if (array_key_exists($type, $currentList)) {
               $returnList[] = $currentList[$type];
            }

         } else {

            foreach($currentList as $item) {
               $returnList[] = $item;
            }

         }

      }

      return $returnList;
   }


   /**
    * Filters the given list for the current request (page)
    *
    * @param $list The list to be filtered
    * @return The filtered list
    */
   private function _pageFilter($list) {

      $hitList = array();
      $backupList = array();

      foreach ($list as $originalItem) {

        $item = clone $originalItem;
        $item->pages = explode('|', $item->pages);

        if (array_intersect(array("ALL", XSession::$PAGE_ID), $item->pages)) {
            $hitList[] = $item;
         } else if (array_search("UNDEF", $item->pages)) {
            $backupList[] = $item;
         }

      }

      return count($hitList) ? $hitList : $backupList;
   }

}
?>