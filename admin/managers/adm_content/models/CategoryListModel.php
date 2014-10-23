<?php

/**
 * Model for a XirtCMS Categories
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class CategoryListModel extends XItemModel {

   /**
    * Loads item information from the database
    */
   public function load() {

      $list = new CategoryList();
      $this->set("list", $list);

   }

}
?>