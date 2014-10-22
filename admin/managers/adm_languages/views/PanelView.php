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

      XPageInfo::addScript("managers/adm_languages/templates/js/manager.js");
      XPageInfo::addStylesheet("managers/adm_languages/templates/css/main.css");

      parent::__construct($model);

   }
}
?>
