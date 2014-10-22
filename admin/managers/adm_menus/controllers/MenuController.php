<?php

/**
 * Controller for XirtCMS Menus
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class MenuController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $actions = array(
         "show", "showDetails", "edit", "toggleSitemap", "toggleMobile", "delete"
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam("id", 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Menu not found", E_USER_NOTICE);
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
    * Shows the data in the Model
    */
   public function showDetails() {
   }


   /**
    * Adds the data in the Model
    */
   protected function add() {

      $list = new MenusModel();

      $this->_model->set("xid",      $list->getMaximum("xid") + 1);
      $this->_model->set("title",    XTools::getParam("nx_title"));
      $this->_model->set("language", XTools::getParam("nx_language"));
      $this->_model->set("ordering", $list->getMaximum("ordering") + 1);

      $this->_model->add();

   }


   /**
    * Modifies the data in the Model
    */
   protected function edit() {

      $this->_model->set("title", XTools::getParam("x_title"));
      $this->_model->save();

   }


   /**
    * Toggles the mobile status for the Model
    */
   protected function toggleSitemap() {

      $value = !intval($this->_model->sitemap);
      $this->_model->set("sitemap", $value);
      $this->_model->save();

   }


   /**
    * Deletes the data in the Model
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>