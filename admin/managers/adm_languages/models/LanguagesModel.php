<?php

/**
 * Models for XirtCMS Languages
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LanguagesModel extends XContentList {

   /**
    * Table with item information
    * @var String
    */
   protected $_table = "#__languages";


   /**
    * Loads list information from the database
    *
    * @return boolean True on succes, false on failure
    */
   public function load() {
      return ($this->_table ? !$this->_load() : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    */
   private function _load() {
      global $xDb;

      // Database query
      $query = "SELECT *               " .
               "FROM %s                " .
               "ORDER BY preference ASC";
      $query = sprintf($query, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new LanguageModel($dbRow), false);
      }

   }

}
?>