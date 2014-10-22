<?php

/**
 * Controller for the management panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class PanelController extends XController {

   /**
    * Initializes the Controller
    *
    * @param $model The Model to use (optional, default null)
    * @param $view The View to use (optional, default null)
    * @param $action The action to execute (optional, default: "show")
    */
   function __construct($model = null, $view = null, $action = "show") {
      parent::__construct($model, $view, $action);
   }

}
?>