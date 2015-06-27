<?php

/**
 * Class that holds the current user session
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XSession {

   /**
    * The unique (menuitem) ID of the page
    * @var int
    */
   public static $PAGE_ID = 0;


   /**
    * Initializes a default session
    */
   public function __construct() {

      new XConfig();
      XMakeCompatible::noCache();
      XmakeCompatible::prepareParams();
      XMakeCompatible::prepareSession();
      XMakeCompatible::hideSmartyErrors();

      session_start();
      $this->_loadUser();
      $this->_loadLanguage();

   }


   /**
    * Loads the language file for this session
    */
   private function _loadLanguage() {
      global $xLang;

      $languages = (new LanguageList)->toArray();
      if (!defined('_ADMIN') && !isset($languages[XConfig::getLanguage()])) {
         XConfig::setLanguage(current($languages)->iso);
      }

      if (!defined('_ADMIN') && !$languages[XConfig::getLanguage()]->published) {
         XConfig::setLanguage(current($languages)->iso);
      }

      $xLang = new XLanguage(XConfig::getLanguage());
      $xLang->load();

   }


   /**
    * Loads the user for this session
    */
   private function _loadUser() {
      global $xUser;

      if (!XAuthentication::check()) {
         return ($xUser = new XUser());
      }

      $xUser = new XUser(XAuthentication::getUserId());

   }


   /**
    * Returns value of a param (GET, POST) defined by the params
    *
    * @param $var The param to return
    * @param $return The default value of the param (optional)
    * @param $type The type to return (optional)
    * @param $force Forces the usage of the _GET instead _POST (optional)
    * @return Mixed the value of the param or the default value
    */
   public static function getParam($var, $return = null, $type = null, $force = null) {

      if (!$force && isset($_POST[$var])) {
         $return = $_POST[$var];
      } elseif (isset($_GET[$var])) {
         $return = $_GET[$var];
      }

      if (!is_null($type)) {
         settype($return, $type);
      }

      return $return;
   }

}
?>