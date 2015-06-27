<?php

/**
 * Component to access utility methods
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      switch (XTools::getParam("task")) {

         case "thumbnail":
            new ImageController(null, null, "thumbnail");
            break;

         case "no_javascript":
            new PanelController(null, "NoJavascriptView", "show");
            break;

         case "show_error":
         case "show_error_401":
         case "show_error_403":
         case "show_error_404":
            new PanelController(null, "ErrorView", "show");
            break;

      }

   }

   /**
    * Handles any AJAX requests
    */
   function showAJAX() {

      switch (XTools::getParam("task")) {

         case "show_languages":
            new AJAXController("LanguageListModel", "LanguageListView", "show");
            break;

      }

   }

}
?>