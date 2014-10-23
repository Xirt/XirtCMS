<?php

/**
 * Model for a list of XirtCMS Content (translations)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ContentListModel extends XTranslationList {

   /**
    * The name of the table containing the information
    * @var String
    */
   protected $_table = "#__content";


   /**
    * Loads list information from the database
    *
    * @param $xId Integer with the xId of the items in the list
    * @return boolean True on succes, false on failure
    */
   public function load($xId) {

      if (parent::load($xId)) {

         if (count($this->list)) {
            $this->set("config", json_decode(reset($this->list)->config));
         }

         return true;
      }

      return false;
   }


   /**
    * Saves changes to the item to the database
    */
   public function save() {

      if (count($this->list)) {

         $this->set("config", json_encode(reset($this->list)->config));
         parent::save();

      }

   }

}
?>