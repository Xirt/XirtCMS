<?php

/**
 * Model for the panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
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

   private function _includeConfiguration() {
      global $xCom;

      $this->configuration = $xCom->xConf;

   }

}
?>