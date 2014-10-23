<?php

/**
 * Controller for XirtCMS Categories
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class CategoryListController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $actions = array("show");

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {
         $this->_model->load();
      }

   }


   /**
    * Shows the data in the Model
    */
   protected function show() {
   }

}
?>