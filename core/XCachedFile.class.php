<?php

/**
 * Class to load and cache file contents
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XCachedFile {

   /**
    * The prefix for cached files
    * @var String
    */
   const CACHE_FILE_PREFIX = "XCF_";


   /**
    * The location of the cached files
    * @var String
    */
   const CACHE_LOCATION = "%s/cache/%s";


   /**
    * Creates a new XCachedFile instance
    *
    * @param $file The location of the source file
    * @param $expiryTime The time (in minutes) before cache expires (default: 900)
    */
   function __construct($file, $expiryTime = 900) {

       $this->_file = $file;

       // Determine cache file
       $this->_cachedFile = sprintf(
          self::CACHE_LOCATION,
          XConfig::get("SESSION_DIR_BASE"),
          self::CACHE_FILE_PREFIX . md5($file)
       );

       // Load file contents into instance
       if (file_exists($this->_cachedFile) && !$this->_isExpired($expiryTime)) {
	      return $this->_retrieve();
	   }

	   $this->_load();

   }


   /**
    * Indicates whether the contents are available in cache
    *
    * @param $expiryTime The time before cached contents expire
    * @return boolean True if cached recently, false otherwise
    */
   private function _isExpired($expiryTime) {
      return (@filemtime($this->_cachedFile) + $expiryTime) < time();
   }


   /**
    * Retrieves cached contents of file
    */
   private function _retrieve() {

      if (!($this->_content = @file_get_contents($this->_cachedFile))) {
         $this->_load();
      }

   }


   /**
    * Loads and caches contents of file
    */
   private function _load() {

      if (!($this->_content = @file_get_contents($this->_file)) ||  $this->_content === false) {
         trigger_error("XCachedFile :: Failed loading source file.", E_USER_WARNING);
      }

      if (!@file_put_contents($this->_cachedFile, $this->_content)) {
         trigger_error("XCachedFile :: Failed caching contents.", E_USER_WARNING);
      }

   }


   /**
    * Returns the contents of the file
    *
    * @return String The contents of the file
    */
   public function getContent() {
      return $this->_content;
   }

}
?>