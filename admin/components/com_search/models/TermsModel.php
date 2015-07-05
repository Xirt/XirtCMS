<?php

/**
 * Models for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class TermsModel extends XContentList {

   /**
    * Table with item information
    * @var String
    */
   protected $_table = "#__search";


   /**
    * The ordering column of the list (for database loading)
    * @var String
    */
   protected $_column = "impressions";


   /**
    * The list of columns used for every item
    * @var Array
    */
   protected $_columns = array("id", "term", "uri");


   /**
    * Initializes Model with requested values
    */
   function __construct() {

      $this->setStart(XTools::getParam("start", 0, _INT));
      $this->setLimit(XTools::getParam("limit", 999, _INT));
      $this->setOrder(XTools::getParam("order", "DESC", _STRING));
      $this->setColumn(XTools::getParam("column", "count", _STRING));
      $this->setFilter(XTools::getParam("filter", "", _STRING));

   }


   /**
    * Loads list information from the database
    *
    * @param $iso The language to load (e.g. "en-GB")
    * @return boolean True on succes, false on failure
    */
   public function load($iso = null) {
      return ($this->_table ? !$this->_load($iso) : false);
   }


   /**
    * Loads all content items from the database and adds them to the list
    *
    * @param $iso The language to load (e.g. "en-GB")
    */
   private function _load($iso = null) {
      global $xDb;

      $searchFilter = array();
      foreach ($this->_columns as $column) {
         $searchFilter[] = sprintf(" %s LIKE '%%%s%%'", $column, $this->_filter);
      }

      $languages = (new LanguageList)->toArray();
      $iso = array_key_exists($iso, $languages) ? $iso : XConfig::get("SESSION_LANGUAGE");

      // Database query
      $query = "SELECT *                        " .
               "FROM %s                         " .
               "WHERE language = :iso HAVING %s " .
               "ORDER BY %s %s                  ";
      $query = sprintf($query, $this->_table, implode(" OR ", $searchFilter), $this->_column, $this->_order);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(":iso", $iso);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItemModel($dbRow), false);
      }

   }

}
?>