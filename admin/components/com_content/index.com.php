<?php

/**
 * Manager for the default XirtCMS Content Viewer
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
      new PanelController("PanelModel", "PanelView", "show");
   }


   /**
    * Handles any AJAX requests
    */
   function showAjax() {
      new ConfigurationController("ConfigurationModel", null, "edit");
   }

}
?>