<?php

/**
 * Model for XirtCMS errors
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ErrorModel extends XModel {

   /**
    * The path to the error log
    * @var String
    */
   const PATH_LOG = "../logs/events.log";


   /**
    * The path to the error log
    * @var String
    */
   const PATH_NOTIFICATION = "../logs/events.log.notified";


   /**
    * Loads item information from the database
    */
   public function load() {

      $errors = array();
      if (file_exists(self::PATH_LOG)) {
         $errors = file(self::PATH_LOG);
      }

      $this->set("entries", $errors);
      $this->set("count", count($errors));
      $this->set("attention", file_exists(self::PATH_NOTIFICATION));

   }


   /**
    * Clears the error log
    */
   public function clear() {

      if (file_exists(self::PATH_LOG)) {
         unlink(self::PATH_LOG);
      }

   }


   /**
    * Resets the notification for the errors
    */
   public function reset() {

      if (file_exists(self::PATH_NOTIFICATION)) {
         unlink(self::PATH_NOTIFICATION);
      }

   }

}
?>