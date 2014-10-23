<?php

/**
 * List containing all available positions
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class PositionList {

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
    * Creates new PositionList instance
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

      foreach ((new TemplateList)->toArray() as $template) {

         foreach (explode('|', $template->positions) as $position) {

            if (($position = trim($position)) && $position) {
         		self::$_list[$position] = $position;
         	}

         }

      }

   }


   /**
    * Returns a filtered list of available template positions
    *
    * @return Array with available template positions
    */
   public function toArray() {
       return self::$_list;
   }

}
?>