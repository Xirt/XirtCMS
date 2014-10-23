<?php

/**
 * TODO: Finish this...
 * List containing all available pages
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class PageList {

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
    * Creates new PageList instance
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

      self::$_list = array();

      // Add items from every menu...
      $menus = XUtils::getMenuList();
      foreach((new MenuList)->toArray() as $id => $menu) {

         if ($id - 1 < count($menus)) {
            $list['-' . $id] = "---";
         }

         // Add menu entries
         $menu = new XMenu($id, null);
         $menu->load();

         foreach($menu->toArray() as $node) {

            //$indent =  XUtils::createIndent($node->level);
            $indent = $node->level;
             $node->name = $indent . $node->name;
            $self::$_list[$node->xid] = $node->name;

         }

      }

   }


   /**
    * Returns a filtered list of available pages
    *
    * @param $showOptionAll Toggles showing option 'All Pages' (default: false)
    * @param $showOptionUnassigned Toggles showing option 'Unassigned' (default: false)
    * @return Array All available pages and options (if requested)
    */
   public function toArray($showOptionAll = false, $showOptionUnassigned = false) {
       global $xLang;

       $list = self::$_list;

       if ($showOptionUnassigned) {

          $list = array_merge(array(
             "undef" => $xLang->misc["optionUnassigned"]
          ), $list);

       }

       if ($showOptionAll) {

       	$list = array_merge(array(
       			"all" => $xLang->misc["optionAllPages"]
       	), $list);

       }

       return $list;
   }

}
?>