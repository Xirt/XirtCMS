<?php

/**
 * Class to notify a user of a password change
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ResetNotification {

   /**
    * The location of the template
    * @var String
    */
   const TEMPLATE = "mails/mail-reset.tpl";


   /**
    * The user details to put in the mail
    * @var UserModel
    */
   private $_user = null;


   /**
    * The subject of the notification
    * @var String
    */
   private $_subject = null;


   /**
    * The body content of the notification
    * @var String
    */
   private $_body = null;


   /**
    * Prepares the notification with the given data
    *
    * @param Object $user The UserModel to use
    * @param String $password The new password
    */
   function __construct($user, $password) {
      global $xCom, $xConf;

      $xLang = (object) $xCom->xLang->mail;

      // Generate notification
      $body = new XTemplate(sprintf(XTemplate::MANAGERS, $xCom->name));
      $body->assign("password", $password);
      $body->assign("xLang",    $xLang);
      $body->assign("xUser",    $user);

      // Save notification
      $this->_user    = $user;
      $this->_subject = $xLang->subject;
      $this->_body    = $body->fetch(self::TEMPLATE);

   }


   /**
    * Sends the e-mail
    */
   function send() {

      $mail = new XMail($this->_user->mail, $this->_subject, $this->_body);
      $mail->setType("html");
      $mail->send();

   }

}
?>