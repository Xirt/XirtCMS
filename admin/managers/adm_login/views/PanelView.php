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

      XConfig::set("USE_TEMPLATE", false);
      XPageInfo::addScript("managers/adm_login/templates/js/main.js");
      XPageInfo::addStylesheet("managers/adm_login/templates/css/main.css", 1);

      parent::__construct($model);

   }

}
?>