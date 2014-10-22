<?php

/**
 * Controller for a Log Entry
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LogEntryController extends XController {


   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $this->_model = new $this->_model;
      $this->_model->load(XTools::getParam("id", 0, _INT));

   }


   /**
    * Show the model (default action)
    */
   protected function show() {
   }


   /**
    * Removes the model
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>