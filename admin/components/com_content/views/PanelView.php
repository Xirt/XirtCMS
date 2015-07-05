<?php

/**
 * View for the panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class PanelView extends XComponentView {

   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      XPageInfo::addScript("components/com_content/templates/js/main.js");
      XPageInfo::addStylesheet("components/com_content/templates/css/main.css");

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign("options", $this->_model->options);
      $this->_template->assign("configuration", $this->_model->configuration);

   }

}
?>