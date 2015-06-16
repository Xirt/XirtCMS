<?php

/**
 * Controller for sending e-mails
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class MailController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $this->_model = new $this->_model;
      if (in_array($this->_action, array("show", "send"))) {
         $this->_ready = $this->_model->load(XTools::getParam("id", 0, _INT));
      }

   }

   /**
    * Show the model (default action)
    */
   protected function show() {
   }


   /**
    * Send the model as e-mail
    */
   protected function send() {

      if ($this->_ready) {

         // Send e-mail
         $mail = new Mail($this->_model);
         $mail->send();

      }

   }

}
?>