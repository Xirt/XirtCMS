<?php

/**
 * Main class used to create page contents
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XPage {

   /**
    * The main content of the page (e.g. component)
    * @var String
    */
   private static $_content = null;


   /**
    * The template used for the page
    * @var String
    */
   private $_template = null;


   /**
    * Creates new XPage instance
    */
   function __construct() {

      $this->_preload();
      $this->_create();
      $this->_render();

   }


   /**
    * Preload page content (e.g. component, template)
    */
   private function _preload() {
      global $xUser;

      // Parameter validation
      $type = XSession::getParam("content");
      if (!XValidate::isSimpleChars($type)) {
          $type = null;
      }

      // Back-end authorization
      if (_ADMIN && !$xUser->isAuth(XConfig::get("MIN_ADMIN_LEVEL"))) {

         if (($type = $type ? $type : "adm_login") && $type != "adm_login") {
            return Xirt::notAuthorized("adm_login");
         }

      }

      // Load requested content
      switch (substr($type, 0, 3)) {

         case "com":

            $factory = new XComponentFactory();
            if (!self::$_content = $factory->get($type)) {
               return;
            }

            break;

         case "adm":

            $factory = new XComponentFactory();
            if (!self::$_content = $factory->get($type, true)) {
               return;
            }

            break;

         case "mod":

            $factory = new XModuleFactory();
            XConfig::set("USE_TEMPLATE", false);
            if (!self::$_content = $factory->get($type)) {
               return;
            }

            break;

         default:

            $factory = new XComponentFactory();
            if (!self::$_content = $factory->get()) {
               trigger_error("XPage :: Homepage not configured ", E_USER_ERROR);
            }

      }

      // Load page data
      $this->_info = new XPageInfo();
      $this->_template = new XPageTemplate();

   }


   /**
    * Creates and buffers main content (e.g. component)
    */
   private function _create() {

      if (!is_null(self::$_content)) {

         ob_start();

         if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {

            self::$_content->showAJAX();
            self::$_content = ob_get_clean();

            return true;

         }

         self::$_content->showNormal();
         self::$_content = ob_get_clean();

      }

   }


   /**
    * Display complete page
    */
   private function _render() {

      if (XConfig::get("USE_TEMPLATE") && $this->_template) {
         return $this->_template->show();
      }

      XInclude::component();

   }


   /**
    * Returns the preloaded main content (e.g. component)
    *
    * @return Preloaded main content
    */
   public static function getMain() {
      return self::$_content;
   }

}
?>
