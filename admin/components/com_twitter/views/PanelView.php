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

      XPageInfo::addScript("components/com_twitter/templates/js/manager.js");
      XPageInfo::addStylesheet("components/com_twitter/templates/css/main.css");

      parent::__construct($model);

   }

}
?>