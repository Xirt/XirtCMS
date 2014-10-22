<?php

/**
 * Controller for a list of XirtCMS Menus (translations)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class MenuListController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $actions = array(
         "show", "translate"
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam("xid", 1, _INT));
         if (!isset(current($this->_model->toArray())->id)) {
            trigger_error("[Controller] Menu not found", E_USER_NOTICE);
         }

      }

   }


   /**
    * Shows the data in the Model
    */
   protected function show() {
   }


   /**
    * Translates the data in the Model
    */
   protected function translate() {

      // Create from best translation
      $iso = XTools::getParam("language");
      foreach ($this->_model->toArray() as $candidate) {

      	if ($candidate->language != $iso) {

            $item = new MenuModel();
            $item->load($candidate->id);

            $item->set("id", null, true);
            $item->set("language", $iso);
            $item->set("title", $item->title . "*");

            $item->add();

         }

      }

   }

}
?>