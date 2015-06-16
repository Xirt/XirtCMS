<?php

/**
 * View for the print version of the model
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class PrintView extends XComponentView {


   /**
    * The defaul template file to load
    * @var String
    */
   protected $_file = "version-print.tpl";


   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      XConfig::set("USE_TEMPLATE", false);
      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign("item", $this->_model);

   }

}
?>