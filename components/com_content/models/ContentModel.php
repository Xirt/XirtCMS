<?php

/**
 * Model holding information on a content item
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ContentModel extends XModel {

   /**
    * Defines whether the instance is a translation of the content or not
    * @var boolean
    */
   var $translation = false;


   /**
    * Load the item from the database
    *
    * @param $id The xId of the item to load
    * @return boolean Return true on success, false on failure
    */
   public function load($id = null) {
      global $xDb;

      $languages = (new LanguageList())->toArray(true);;
      $iso = current($languages)->preference;

      // Query (selection)
      $query = "SELECT *                                   " .
               "FROM (%s) AS subset                        " .
               "LIMIT 2                                    ";

      // Subquery (translations)
      $trans = "SELECT t1.*, preference                    " .
               "FROM #__content AS t1                      " .
               "INNER JOIN #__languages AS t2              " .
               "ON t1.language = t2.iso                    " .
               "WHERE t1.published = 1                     " .
               "  AND xid = :id                            " .
               "ORDER BY replace(t2.preference, :iso, 0)   ";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(":iso", $iso, PDO::PARAM_STR);
      $stmt->bindParam(":id", $id, PDO::PARAM_INT);
      $stmt->execute();

      // Populate instance
      if ($item = $stmt->fetchObject()) {
         return $this->_init($item);
      }

      return false;
   }


   /**
    * Initializes instance with given data
    *
    * @param $data Object containing data to initialize instance
    * @return boolean Always true
    */
   private function _init($data) {

      foreach ($data as $name => $value) {
         $this->$name = $value;
      }

      // Variables parsing
      $this->translation = ($data->language != XConfig::get("SESSION_LANGUAGE"));
      $this->config      = $this->_parseConfiguration($this->config);
      $this->content     = $this->_parseContent($this->content);

      // Creation date
      if ($this->config->show_created) {

         $this->created = new DateTime($this->created);
         $this->created = $this->created->format(XConfig::get("FORMAT_DATETIME"));

      }

      // Modification date
      if ($this->config->show_modified) {

         $modified = new DateTime($this->modified);
         $this->modified = $modified->format(XConfig::get("FORMAT_DATETIME"));
         $this->modified = ($modified->format("U") > 0) ? $this->modified : 0;

      }

      return true;
   }


   /**
    * Sets the configuration of the item
    *
    * @param $config The configuration to parse
    * @return String the parsed configuration
    */
   private function _parseConfiguration($config) {
      global $xCom;

      $list = (Object)array();
      foreach (json_decode($config) as $key => $val) {

         $val = ($val == -1) ? $xCom->xConf->$key : $val;
         $list->$key = $val;

      }

      return $list;
   }


   /**
    * Parses the given content
    *
    * @param $content The content to parse
    * @return String the parsed content
    */
   private function _parseContent($content) {
      return XSEF::parse($content);
   }

}
?>