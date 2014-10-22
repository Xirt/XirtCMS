<?php

/**
 * Model for a list of XirtCMS Usergroup (translations)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class UsergroupListModel extends XTranslationList {

   /**
    * Name of the column acting as identifier (xId)
    * @var String
    */
   protected $_identifier = "rank";


   /**
    * Name of the table containing the information
    * @var String
    */
   protected $_table = "#__usergroups";

}
?>