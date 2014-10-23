<?php

/**
 * View for the management panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class PanelView extends XComponentView {

   /**
    * Shows the model on destruction
    *
    * @param $model The model with the data to show
    */
   function __construct($model) {

      XPageInfo::addScript("managers/adm_content/templates/js/manager.js");
      XPageInfo::addStylesheet("managers/adm_content/templates/css/main.css");

      parent::__construct($model);

   }


   /**
    * Method executed on initialization
    */
   protected function _init() {

      parent::_init();
      $this->_template->assign("ranks", $this->_model->ranks);
      $this->_template->assign("options", $this->_model->options);
      $this->_template->assign("languages", $this->_model->languages);

   }

}
?>