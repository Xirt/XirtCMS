<?php

/**
 * Controller for XirtCMS Usergroups
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class UsergroupsController extends XController {

   /**
    * Show the model (default action)
    */
   protected function show() {
      $this->_model->load(XTools::getParam("iso"));
   }

}
?>