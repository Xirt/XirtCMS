<?php

/**
 * Models for Users
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class UsersModel extends XContentList {

   /**
    * @var String Table with item information
    */
   protected $_table = "#__users";


   /**
    * @var String The ordering column of the list (for database loading)
    */
   protected $_column = "id";


   /**
    * @var Array The list of columns used for every item
    */
   protected $_columns = array(
      "id", "rank", "name", "username", "mail", "dt_joined", "dt_login", "login_attempts"
   );


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