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

      $this->_includeLanguages();
      $this->_includeConfiguration();

   }

   /**
    * Includes the component configuration
    */
   private function _includeConfiguration() {
      global $xCom;

      $this->configuration = $xCom->xConf;

   }

}
?>