<?php

/**
 * View for the component in XML
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XMLView extends XComponentView {


   /**
    * The defaul template file to load
    * @var String
    */
   protected $_file = "xml.tpl";


   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      XConfig::set("USE_TEMPLATE", false);
      header("Content-type: application/xml; charset='utf-8'");

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign("nodes", $this->_model->toArray());

   }

}
?>