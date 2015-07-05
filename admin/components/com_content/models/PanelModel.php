<?php

/**
 * Model for the panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class PanelModel extends XComponentModel {

   /**
    * Method to load data
    */
   public function load() {

      $this->_includeOptions();
      $this->_includeConfiguration();

   }


   /**
    * Includes option list for the (default) XirtCMS Content Viewer
    */
   private function _includeOptions() {
      global $xCom;

      $this->options = array(
         $xCom->xLang->options["hideItem"],
         $xCom->xLang->options["showItem"]
      );

   }


   /**
    * Includes the current configuration for the XirtCMS Content Viewer
    */
   private function _includeConfiguration() {

      $this->configuration = new ConfigurationModel();
      $this->configuration->load();

   }

}
?>