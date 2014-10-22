<?php

/**
 * Models for XirtCMS Components
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ComponentsModel extends XContentList {

   /**
    * The name of the table containing the information
    * @var String
    */
   protected $_table = "#__components";


   /**
    * The ordering column of the list (for database loading)
    * @var String
    */
   protected $_column = "name";


   /**
    * The list of columns used for every item
    * @var Array
    */
   protected $_columns = array("id", "name");


   /**
    * Initializes Model with requested values
    */
   function __construct() {

      $this->setStart(XTools::getParam("start", 0, _INT));
      $this->setLimit(XTools::getParam("limit", 999, _INT));
      $this->setOrder(XTools::getParam("order", "DESC", _STRING));
      $this->setColumn(XTools::getParam("column", "id", _STRING));
      $this->setFilter(XTools::getParam("filter", "", _STRING));

   }

}
?>