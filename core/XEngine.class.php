<?php

/**
 * The core class that generates the whole page
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XEngine {

   /**
    * Starts the generation
    */
   function __construct() {
      $this->_init();
   }


   /**
    * Initializes the core engine
    */
   private function _init() {
      global $xDb, $xPage, $xSession;

      new XLog();

      // Set main  variables
      $xDb      = new XDatabase();
      $xSession = new XSession();
      $xPage    = new XPage();

   }

}
?>