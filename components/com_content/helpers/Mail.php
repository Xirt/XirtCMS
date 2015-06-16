<?php

/**
 * Class to send recommendation e-mails
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class Mail {

   /**
    * Internal variable for holding content object
    * @var Object
    */
   private $_item;


   /**
    * Creates a new recommendation mail for the given item
    *
    * @param $item The content for the e-mail
    */
   function __construct($item) {
      $this->_item = $item;
   }


   /**
    * Attempts to send the e-mail
    *
    * @return boolean True on success, false on failure
    */
   public function send() {

      if (($data = $this->_receive()) && $this->_check($data)) {
         return $this->_send($data);
      }

      return false;
   }


   /**
    * Captures the form data in an object
    *
    * @return Object containing form data or null on failure
    */
   private function _receive() {

      return (Object)array(
         "url"      => self::_getLink($this->_item),
         "name"     => XTools::getParam("x_name"),
         "rec_name" => XTools::getParam("x_rec_name"),
         "rec_mail" => XTools::getParam("x_rec_mail")
      );

   }


   /**
    * Sends the e-mail to the set recipient
    *
    * @param $data Object containing the form data
    * @return boolean True if validated, false otherwhise
    */
   private function _check($data) {

      $valid = true;
      $valid = XValidate::hasLength($data->name, 1, 50)     ? $valid : false;
      $valid = XValidate::hasLength($data->rec_name, 1, 50) ? $valid : false;
      $valid = XValidate::isMail($data->rec_mail, 1, 50)    ? $valid : false;

      return $valid;
   }


   /**
    * Sends the e-mail to the set recipient
    *
    * @param data Object containing the form data
    */
   private function _send($data) {
      global $xCom;

      // Subject
      $subject = vsprintf($xCom->xLang->misc["subject"], $data->name);
      $subject = html_entity_decode($subject, ENT_QUOTES);

      // Content
      $content = new XTemplate(sprintf(XTemplate::COMPONENTS, $xCom->name));
      $content->assign("baseURI", XConfig::get("SESSION_URL_BASE"));
      $content->assign("xLang", $xCom->xLang);
      $content->assign("data", $data);
      $content = $content->fetch("mail.tpl");
      $content = html_entity_decode($content, ENT_QUOTES);

      // Sent mail
      $mail = new XMail($data->rec_mail, $subject, $content);
      $mail->setType("html");
      $mail->send();

   }


   /**
    * Returns the link for the given item
    *
    * @param $item The ContenItem to retrieve the link for
    * @return String The link to the given item
    */
   private static function _getLink($item) {

      return XConfig::get("SESSION_URL_BASE") .
             "index.php?content=com_content&id=" .
             $item->id;

   }

}
?>