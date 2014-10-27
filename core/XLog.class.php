<?php

/**
 * Class to generate log file entries and notify administrators
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XLog {

   /**
    * The fallback file for writing fatal errors (in case DB logging fails)
    * @var String
    */
   private $_file = "events.log";


   /**
    * The (default) folder for writing log files
    * @var String
    */
   private $_folder = "logs/";


   /**
    * Creates a log with the given or default log file location as fallback
    *
    * @param $file The file to use as log file (optional)
    * @param $folder The folder to use as storage (optional)
    */
   function __construct($file = null, $folder = null) {

      set_error_handler(array($this, "onError"));
      //set_exception_handler(array($this, "onException"));

      $this->_file = is_null($file) ? $this->_file : $file;
      $this->_folder = is_null($folder) ? $this->_folder : $folder;

   }


   /**
    * Logs thrown (generated) errors
    *
    * @param $no The error number of the event
    * @param $str The message explaining the event
    * @param $src The file in which the event was triggered
    * @param $line The line in which the event was triggered
    */
   public function onError($no, $str, $src, $line) {
      $this->_log(new XLogEntry($no, $str, $src, $line));
   }


   /**
    * Logs thrown non-captured exceptions
    *
    * @param $e The Exception to be logged
    */
   public function onException(Exception $e) {
      $this->_log(XLogEntry::fromException($e));
   }


   /**
    * Clears the contents of the DB log and associated fallback files
    *
    * @param $keepFallBackFiles Skips deletion of fallback files (default: false)
    */
   public function clear($keepFallbackFiles = false) {
      global $xDb;

      // Empty database
      $stmt = $xDb->prepare("TRUNCATE TABLE #__log");
      $stmt->execute();

      if (!$keepFallBackFiles) {

         // Empty event file
         $file = $folder . $file;
         if (file_exists($file) && !@unlink($file)) {
            trigger_error("XLog :: Could not clear event log", E_USER_WARNING);
         }

         // Reset event notification
         $notification = $file . ".notified";
         if (file_exists($notification) && !@unlink($notification)) {
            trigger_error("XLog :: Could not reset notification", E_USER_WARNING);
         }

      }

   }


   /**
    * Logs an event to the event log
    *
    * @param $data Extended information on event
    */
   private function _log($data) {

      // Ignore controlled errors (@)
      if (0 === error_reporting()) {
         return false;
      }

      // Catch errors during start-up
      if (!XConfig::$CONF_INITIALIZED) {

         $this->_toFile($data);
         die("XLog :: XEngine could not initialize");

      }

      switch ($data->error_no) {

         case E_USER_NOTICE:
         case E_USER_WARNING:
            $this->_toDatabase($data);
            break;

         case E_USER_ERROR:

            $this->_toFile($data);
            $this->_display($data);

            if (!XConfig::get("DEBUG_MODE") && XConfig::get("ERROR_NOTIFY")) {
               $this->_notify($data);
            }

            exit;

         default:

            // Hides notices / warnings in live-mode
            if (XConfig::get("DEBUG_MODE") && $data->error_no < E_USER_ERROR) {
               $this->_display($data);
            }

            break;

      }

   }


   /**
    * Saves event data to the database
    *
    * @param $data Extended information on event
    */
   private function _toDatabase($data) {
      global $xDb;

      if (isset($xDb) && !is_null($xDb)) {
         $xDb->insert("#__log", $data);
      }

   }


   /**
    * Saves event data to the log file
    *
    * @param $data Extended information on event
    */
   private function _toFile($data) {

      $realpath = XConfig::get("SESSION_DIR_BASE") . $this->_folder;
      if (!$handle = @fopen($realpath . $this->_file, 'a')) {
         die("XLog :: Cannot open log file.");
      }

      @fwrite($handle, sprintf("[%s]", $data->time));
      @fwrite($handle, sprintf("[%s]", $data->error_no));
      @fwrite($handle, sprintf(" %s" . nl , $data->error_msg));
      @fclose($handle);

   }


   /**
    * Shows errors when in debugmode
    *
    * @param $data Extended information on event
    */
   private function _display($data) {
      global $xLang;

      $tpl = new XTemplate();
      $tpl->assign("data", $data);
      $tpl->assign("xLang", isset($xLang) ? $xLang : null);
      $tpl->display("templates/xtemplates/display-error.tpl");

      $protocol = isset($_SERVER["SERVER_PROTOCOL"]) ? $_SERVER["SERVER_PROTOCOL"] : "HTTP/1.1";
      header($protocol . " 500 Internal Server Error", true, 500);

   }


   /**
    * Notify the administrator of an event
    *
    * @param $data Extended information on event
    */
   private function _notify($data) {
      global $xConf;

      $file = $this->_file . ".notified";
      if (!XConfig::get("ERROR_NOTIFY_MAIL") || @file_exists($file)) {
         return;
      }

      // Prepare e-mail
      $body = new XTemplate();
      $body->assign("data", $data);
      $body = $body->fetch("templates/xtemplates/mail-error.tpl");

      // Sent e-mail notification
      $mail = new XMail(XConfig::get("ERROR_NOTIFY_MAIL"), "[XirtCMS] Log event", $body);
      $mail->send();

      touch($file);

   }

}
?>