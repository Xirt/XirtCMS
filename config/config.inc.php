<?php

/**
 * Class to hold database connection information
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class DBConfig {

   /**
    * The host (DNS) for the database
    * @var String
    */
   public static $HOST_URL = "mysql:host=localhost;dbname=XirtCMS";


   /**
    * The username for the database
    * @var String
    */
   public static $USERNAME = "root";


   /**
    * The password for the database
    * @var String
    */
   public static $PASSWORD = "password";


   /**
    * The table prefix for the database
    * @var String
    */
   public static $PREFIX = "xirt";

}
?>
