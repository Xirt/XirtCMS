<?php

/**
 * Controller for XirtCMS Languages
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LanguagesController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $this->_model = new $this->_model;
      $this->_model->load();

   }


   /**
    * Show the model
    */
   protected function show() {
   }


   /**
    * Move item up the list of the Model
    */
   protected function moveUp() {

      // Current item
      $id = XTools::getParam("id", 0, _INT);
      $item = $this->_model->getItemByAttribute("id", $id);

      // Previous item (to be switched)
      $preference = $item->preference - 1;
      $prev = $this->_model->getItemByAttribute("preference", $preference);

      if ($item && $prev) {

         $prev->set("preference", $prev->get("preference") + 1);
         $item->set("preference", $item->get("preference") - 1);

         // Always activate primary language
         if ($item->get("preference") === 1) {
            $item->set("published", 1);
         }

         $prev->save();
         $item->save();

      }

   }


   /**
    * Move item down the list of the Model
    */
   protected function moveDown($id) {

      // Current item
      $id = XTools::getParam("id", 0, _INT);
      $item = $this->_model->getItemByAttribute("id", $id);

      // Next item (to be switched)
      $preference = $item->preference + 1;
      $next = $this->_model->getItemByAttribute("preference", $preference);

      if ($item && $next) {

         $item->set("preference", $item->get("preference") + 1);
         $next->set("preference", $next->get("preference") - 1);

         $item->save();
         $next->save();

      }

   }

}
?>