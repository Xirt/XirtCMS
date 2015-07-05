<?php

/**
 * Utility class to include XirtCMS page items
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XInclude {


   /**
    * The default location of plugins (JS)
    * @var String
    */
   const PATH_PLUGINS = "js/plugins/%s/plugin.js";


   /**
    * The default location of modules
    * @var String
    */
   const PATH_MODULES = "%s/modules/%s/index.mod.php";


   /**
    * Shows the head of the page (title, meta, css, js)
    */
   public static function header() {

      // Prepare page title
      $title = implode(array_reverse(XPageInfo::$titles), " | ");

      // Prepare stylesheets
      asort(XPageInfo::$stylesheets);
      $stylesheets = array_keys(XPageInfo::$stylesheets);

      // Prepare JavaScript files (combine if requested)
      if (!XConfig::get("DEBUG_MODE") && XConfig::get("COMBINE_SCRIPTS") && !_ADMIN) {

         $list = array();
         foreach (XPageInfo::$systemScripts as $key => $file) {

            if (strpos($file, "://") === false) {

               unset(XPageInfo::$systemScripts[$key]);
               $list[] = $file;

            }

         }

         XPageInfo::$systemScripts[] = "xjs/" . implode(",", $list);

      }

      $scripts = array_merge(XPageInfo::$systemScripts, XPageInfo::$scripts);

      // Show template
      $tpl = new XTemplate();
      $tpl->assign("title", $title);
      $tpl->assign("scripts", $scripts);
      $tpl->assign("stylesheets", $stylesheets);
      $tpl->assign("metatags", XPageInfo::$metaTags);
      $tpl->display("templates/xtemplates/display-header.tpl");

      XPageInfo::included();

   }


   /**
    * Includes a plugin in the page (for JavaScript plugins)
    *
    * @param $type The plugin to load
    */
   public static function plugin($type) {
      global $xPage;

      if (!defined("PLUGIN." . $type)) {

         define("PLUGIN." . $type, 1);
         $path = sprintf(self::PATH_PLUGINS, $type);
         $path = _ADMIN ? "../" . $path : $path;

         // Find plugin
         if (!file_exists($path)) {

            trigger_error("[XCore] Plugin not found ({$type})", E_USER_NOTICE);
            return false;

         }

         if (!XPageInfo::addScript($path)) {

            $tpl = new XTemplate();
            $tpl->assign("xConf", $xConf);
            $tpl->assign("script", $path);
            $tpl->display("templates/xtemplates/display-script.tpl");

         }

      }

   }


   /**
    * Shows the main content of the site (after preloading)
    */
   public static function component() {
      print(XPage::getMain());
   }


   /**
    * Load/shows module for defined position (used in templates)
    *
    * @param $position String containing the name of the position
    */
   public static function module($position) {

      $modules = (new ModuleList)->toArray([
         "POSITION" => $position,
         "LANGUAGE" => "en-GB"
         ], true
      );

      if (count($modules)) {

         foreach ($modules as $module) {

            $type = $module->type;
            $path = sprintf(self::PATH_MODULES, XConfig::get("SESSION_DIR_BASE"), $type);

            if (!@is_readable($path)) {

               trigger_error("Module failure ({$type})", E_USER_WARNING);
               continue;

            }

            require_once($path);
            new $type($module->config);

         }

      }

   }


   /**
    * Shows parsing knowledge in debug mode (default behavior)
    *
    * @param $ignore When true, statistics are always shown
    */
   public static function statistics($ignore = false) {
      global $xDb, $xStart;

      if (!XConfig::get("DEBUG_MODE") || $ignore) {
         return false;
      }

      // Show template
      $tpl = new XTemplate();
      $tpl->assign("memoryUse", round(memory_get_peak_usage() / 1048576, 3));
      $tpl->assign("parseTime", round(microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"], 3));
      $tpl->assign("queryTime", round($xDb->timer, 3));
      $tpl->assign("queryCount", count($xDb->cache));
      $tpl->display("templates/xtemplates/display-statistics.tpl");

   }

}
?>
