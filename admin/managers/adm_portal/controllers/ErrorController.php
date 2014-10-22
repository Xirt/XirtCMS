<?php

/**
 * Controller for the management panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ErrorController extends XController {

   /**
    * Removes the model (all errors) and resets (error) notification
    */
   protected function clear() {

      $this->_model->clear();
      $this->reset();

   }


   /**
    * Resets the (error) notification for the model
    */
   protected function reset() {
      $this->_model->reset();
   }

}
?>