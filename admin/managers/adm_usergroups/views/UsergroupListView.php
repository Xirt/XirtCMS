<?php

/**
 * View for a list of XirtCMS Usergroup (translations)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class UsergroupListView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>