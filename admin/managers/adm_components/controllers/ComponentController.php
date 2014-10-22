<?php

/**
 * Controller for XirtCMS Components
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ComponentController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $actions = array(
         "show", "editAccess"
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam("id", 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Component not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Shows the data in the Model
    */
   protected function show() {
   }


   /**
    * Modifies the access data in the Model
    */
   protected function editAccess() {

   	  if ($this->_model->id > 1) {

         $this->_model->set("access_min", XTools::getParam("access_min", 0, _INT));
         $this->_model->set("access_max", XTools::getParam("access_max", 0, _INT));
         $this->_model->save();

   	  }

   }

}
?>