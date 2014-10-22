<?php

/**
 * Models for XirtCMS Menus
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class MenusModel extends XContentList {

   /**
    * Table with item information
    * @var String
    */
   protected $_table = "#__menus";


   /**
    * The ordering column of the list (for database loading)
    * @var String
    */
   protected $_column = "ordering";


   /**
    * The list of columns used for every item
    * @var Array
    */
   protected $_columns = array("xid", "title");


   /**
    * Initializes Model with requested values
    */
   function __construct() {

      $this->setStart(XTools::getParam("start", 0, _INT));
      $this->setLimit(XTools::getParam("limit", 999, _INT));
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
   protected function _load($iso = null) {
      global $xDb;

      $searchFilter = array();
      foreach ($this->_columns as $column) {
         $searchFilter[] = sprintf(" %s LIKE '%%%%%s%%%%'", $column, $this->_filter);
      }

      $languages = (new LanguageList)->toArray();
      $iso = array_key_exists($iso, $languages) ? $iso : XConfig::get("SESSION_LANGUAGE");
      $iso = intval($languages[$iso]->preference);

      // Query (selection)
      $query = "SELECT *                                                    " .
               "FROM (%%s) AS subset                                        " .
               "GROUP BY xid                                                " .
               "HAVING %s                                                   " .
               "ORDER BY ordering                                           ";
      $query = sprintf($query, implode(" OR ", $searchFilter));

      // Subquery (translations)
      $trans = "SELECT t1.*, replace(t2.preference, :iso, 0) as translation " .
               "FROM %s AS t1                                               " .
               "INNER JOIN #__languages AS t2                               " .
               "ON t1.language = t2.iso                                     " .
               "ORDER BY replace(t2.preference, :iso, 0)                    ";
      $trans = sprintf($trans, $this->_table);

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(":iso", $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {
         $this->_add(new XItemModel($dbRow), false);
      }

   }

}
?>