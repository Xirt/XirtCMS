<?php

/**
 * Model for single Tweets
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class TweetModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load($id) {
      parent::loadFromDatabase("#__twitter", $id);
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {
      parent::saveToDatabase("#__twitter");
   }


   /**
    * Removes item from the database
    */
   public function delete() {
      parent::deleteFromDatabase("#__twitter");
   }

}
?>