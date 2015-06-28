<?php

/**
 * Model for the management panel
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

      $this->_includeRanks();
      $this->_includeModules();
      $this->_includePositions();
      $this->_includeLanguages();
      $this->_includePages(true, true);

   }

}
?>