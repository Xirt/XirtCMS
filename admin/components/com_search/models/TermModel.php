<?php

/**
 * Model for a XirtCMS Search Term
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class TermModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase("#__search", $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function add() {
      parent::addToDatabase("#__search");
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase("#__search");
   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase("#__search");
   }

}
?>