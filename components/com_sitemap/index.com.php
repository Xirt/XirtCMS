<?php

/**
 * Component to initalize SitemapViewer
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class Component extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {

      switch (XTools::getParam("task")) {

         case "use_xml":
            new PanelController("SitemapModel", "XMLView", "show");
            break;

         default:
            new PanelController("SitemapModel", "HTMLView", "show");
            break;

      }

   }

}
?>