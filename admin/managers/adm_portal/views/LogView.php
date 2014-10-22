<?php

/**
 * View for Logs
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LogView extends XJSONView {

   /**
    * Method executed on initialization (overwritable)
    */
   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>