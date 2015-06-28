<?php

/**
 * TODO :: Check if this class can be replaced (ModuleFactory?)
 * List containing all available modules
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ModuleList {

   /**
    * The path to the modules
    * @var String
    */
   const PATH_MODULES = "%smodules/";


   /**
    * List of all items
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

      self::$_list = array();
      $path = sprintf(self::PATH_MODULES, XConfig::get("SESSION_DIR_BASE"));

         if ($handle = @opendir($path)) {

         while (($subdir = @readdir($handle)) !== false) {

            if (!is_dir($path . $subdir)) {
               continue;
            }

            $file = $subdir . "/index.mod.xml";
            if (!is_readable($path . $file)) {
               continue;
            }

            try {
               $moduleInfo = new SimpleXMLElement($path . $file, null, true);
            }
            catch (Exception $e) {
               trigger_error("[XUtils] XML Failure ({$subdir}).", E_USER_WARNING);
            }

            if (!isset($moduleInfo->name)) {
               continue;
            }

            self::$_list[$subdir] = (String)$moduleInfo->name;
         }

         asort(self::$_list);
         return @closedir($handle);

      }

      trigger_error("[XUtils] Modules unavailable.", E_USER_WARNING);

   }


   /**
    * Returns a list of available modules
    *
    * @return Array with available modules
    */
   public function toArray() {
   	  return self::$_list;
   }

}
?>