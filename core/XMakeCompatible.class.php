<?php

/**
 * Utility Class to ensure compatiblity with various environments
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XMakeCompatible {

   /**
    * Prevents caching of website in browser
    */
   public static function noCache() {

      session_cache_limiter("nocache");
      header("Cache-Control: no-store, no-cache, must-revalidate");
      header("Expires: Sun, 15 Jun 1986 00:00:00 GMT");
      header("Pragma: no-cache");

   }


   /**
    * Decodes a SEF URL into a regular page query
    */
   public static function prepareParams() {

      if (_ADMIN || !XConfig::get("SEO_LINKS")) {
         return false;
      }

      // Compare _SERVER to retrieve URI (strip directory)
      $requestBits = str_split(pathinfo($_SERVER["REQUEST_URI"], PATHINFO_DIRNAME));
      $scriptBits = str_split(pathinfo($_SERVER["SCRIPT_NAME"], PATHINFO_DIRNAME));
      $maxLength = min(count($requestBits), count($scriptBits));

      for ($i = 0; $i < $maxLength && $requestBits[$i] == $scriptBits[$i]; $i++);
      $uri = substr($_SERVER["REQUEST_URI"], $i + 1);

      if (strpos($uri, XConfig::get("SESSION_URL_BASE")) === 0) {
         $uri = substr($uri, strlen(XConfig::get("SESSION_URL_BASE")));
      }

      // Parse URL (if known)
      $link = XLinkFactory::retrieve($uri);
      if ($link != null && $link->query && $link->iso) {

         parse_str(parse_url($link->query, PHP_URL_QUERY), $args);
         XConfig::setLanguage($link->iso);
         $_GET = array_merge($_GET, $args);

         if (!array_key_exists("cid", $_GET)) {
            $_GET["cid"] = $link->cid;
         }

      }

   }


   /**
    * Prepares session according to settings
    */
   public static function prepareSession() {

      if (XConfig::get("SESSION_USE_DB")) {

         register_shutdown_function("session_write_close");

         session_set_save_handler(
            array("XDBSession", "open"),
            array("XDBSession", "close"),
            array("XDBSession", "read"),
            array("XDBSession", "write"),
            array("XDBSession", "destroy"),
            array("XDBSession", "clean")
         );

      }

   }


   /**
    * Prevents Smarty from showing errors
    */
   public static function hideSmartyErrors() {

      require_once("smarty/Smarty.class.php");
      Smarty::muteExpectedErrors();

   }

}
?>