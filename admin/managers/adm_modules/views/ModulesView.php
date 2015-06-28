<?php

/**
 * View for XirtCMS Modules
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ModulesView extends XJSONView {

   /**
    * Method executed on initialization
    */
   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>