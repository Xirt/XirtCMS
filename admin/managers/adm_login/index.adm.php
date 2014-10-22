<?php

/**
 * Manager for handling authentication (back-end)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      global $xUser;

      switch (XTools::getParam("task")) {

         case "logout":

            new LoginController(null, null, "logout");
            new PanelController(null, "PanelView", "show");

            break;

         default:

            if ($xUser->isAuth(XConfig::get("MIN_ADMIN_LEVEL"), 100)) {
               die(header("Location: index.php?content=adm_portal"));
            }

            new PanelController(null, "PanelView", "show");
            break;

      }

   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam("task")) {

         case "attempt_login":
            new LoginController(null, null, "login");
            break;

         case "request_password":
            new UserController("UserModel", null, "reset");
            break;

      }

   }

}
?>