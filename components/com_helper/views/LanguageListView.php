<?php

/**
 * View for retrieving a list of XirtCMS languages (JSON)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class LanguageListView extends XJSONView {

   /**
    * Method executed on initialization
    */
   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>