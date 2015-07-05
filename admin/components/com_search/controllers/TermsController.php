<?php

/**
 * Controller for XirtCMS Search Terms
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class TermsController extends XController {

   /**
    * Show the model
    */
   protected function show() {
      $this->_model->load(XTools::getParam("iso"));
   }

}
?>