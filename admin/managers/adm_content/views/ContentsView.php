<?php

/**
 * View for XirtCMS Content
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ContentsView extends XJSONView {

   /**
    * Method executed on initialization
    */
   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>