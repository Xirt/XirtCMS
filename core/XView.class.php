<?php

/**
 * Default View for XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XView {

   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      $this->_model = $model;
      $this->_init();

   }


   /**
    * Method executed on initialization (overwritable)
    */
   protected function _init() {
   }


   /**
    * Shows the model on destruction
    */
   public function __destruct() {
   }

}
?>