<?php

/**
 * Controller for XirtCMS Modules
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ModulesController extends XController {

   /**
    * Show the model (default action)
    */
   protected function show() {
      $this->_model->load(XTools::getParam("iso"));
   }

}
?>