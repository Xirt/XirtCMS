<?php

/**
 * Model for a Log Entry
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LogEntryModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id = null) {
      parent::loadFromDatabase("#__log", $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase("#__log");
   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase("#__log");
   }

}
?>