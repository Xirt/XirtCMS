<?php

/**
 * View for the component in HTML
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class HTMLView extends XComponentView {


   /**
    * The defaul template file to load
    * @var String
    */
   protected $_file = "html.tpl";


   /**
    * Method executed on initialization
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign("menus", $this->_model->list);

   }

}
?>