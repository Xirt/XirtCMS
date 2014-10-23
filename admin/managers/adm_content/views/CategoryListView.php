<?php

/**
 * View for XirtCMS Categories
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class CategoryListView extends XJSONView {

   /**
    * Method executed on initialization
    */
   function __destruct() {
      $this->_model->list->show();
   }

}
?>