<?php

/**
 * Helper class for Component
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ContentHelper {

   /**
    * The list of plugins for this Component
    * @var String
    */
   protected static $_plugins = null;


   /**
    * The location of the plugins for tihs Component
    * @var String
    */
   protected static $_path = "components/com_content/plugins";


   /**
    * Returns a list of plugins for this Component
    *
    * @return Array The list of loaded plugins (instances)
    */
   public static function getPlugins() {

      if (ContentHelper::$_plugins != null) {
         return ContentHelper::$_plugins;
      }

      // Load all plugins
      ContentHelper::$_plugins = array();
      foreach ((new XDir(ContentHelper::$_path))->summarize() as $filePath) {

         require_once $filePath;
         $className = basename($filePath, ".php");
         ContentHelper::$_plugins[] = new $className();

      }

      return ContentHelper::$_plugins;

   }

}
?>