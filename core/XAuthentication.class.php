<?php

/**
 * Utility Class to handle authentication procedures
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XAuthentication {

   /**
    * Returns the userId of the visitor
    *
    * @return mixed Returns the current userId or null on failure
    */
   public static function getUserId() {

      if (isset($_SESSION["id"])) {
         return intval($_SESSION["id"]);
      }

      if (isset($_COOKIE["id"])) {
         return intval($_COOKIE["id"]);
      }

      return null;
   }


   /**
    * Checks whether the current visiter is authenticated or not
    *
    * @return mixed Return true if visiter is authenticated, false otherwhise
    */
   public static function check() {

      $ip = $_SERVER["REMOTE_ADDR"];

      $uId  = isset($_COOKIE["id"])    ? $_COOKIE["id"]    : null;
      $uId  = isset($_SESSION["id"])   ? $_SESSION["id"]   : $uId;

      $pass = isset($_COOKIE["pass"])  ? $_COOKIE["pass"]  : null;
      $pass = isset($_SESSION["pass"]) ? $_SESSION["pass"] : $pass;

      $hash = isset($_COOKIE["hash"])  ? $_COOKIE["hash"]  : null;
      $hash = isset($_SESSION["hash"]) ? $_SESSION["hash"] : $hash;

      $authStr = $ip . $uId . $pass . XConfig::get("AUTH_SECRET");
      $candidate = hash(XConfig::get("AUTH_HASH_TYPE"), $authStr);

      return ($candidate == $hash);
   }


   /**
    * Attempts to authenticate the current visitor
    *
    * @param $username The username of the user to authenticate
    * @param $password The password of the user to authenticate
    * @param $cookies Toggles the use of cookies (defaults to false)
    * @return int 1 on success, error code otherwise
    */
   public static function create($username, $password, $cookies = false) {
      global $xDb;

      XAuthentication::destroy();
      session_regenerate_id();

      if (!($out = XAuthentication::_verify($username, $password)) || $out < 1) {

         self::_track($username);
         return $out;

      }

      $password = self::hash($password);
      $ip       = $_SERVER["REMOTE_ADDR"];
      $authStr  = $ip . $out . $password . XConfig::get("AUTH_SECRET");
      $hash     = hash(XConfig::get("AUTH_HASH_TYPE"), $authStr);

      if ($cookies) {

         setcookie("id"   , $out     , time() + 31536000);
         setcookie("pass" , $password, time() + 31536000);
         setcookie("hash" , $hash    , time() + 31536000);

      }

      $_SESSION["id"]   = $out;
      $_SESSION["pass"] = $password;
      $_SESSION["hash"] = $hash;

      self::_track($username, true);
      return 1;

   }


   /**
    * Update account to track (failed) login attempts
    *
    * @param $username The username of the account to update
    * @param $resetCounter Toggles resetting of the tracker (default: false)
    */
   private static function _track($username, $resetCounter = false) {
      global $xDb;

      if ($resetCounter) {

         // Reset the counter (login success)
         $query = "UPDATE #__users                         " .
                  "SET dt_login = NOW(),                   " .
                  "    login_attempts = 0                  " .
                  "WHERE username LIKE BINARY :username    ";
      } else {

         // Update the counter (login failure)
         $query = "UPDATE #__users                         " .
                  "SET dt_login = NOW(),                   " .
                  "    login_attempts = login_attempts + 1 " .
                  "WHERE username LIKE BINARY :username    ";

      }

      // Query execution
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt->execute();

   }


   /**
    * Destroys authentication
    *
    * @return boolean true
    */
   public static function destroy() {

      setcookie("id"  , 0, time() - 3600);
      setcookie("pass", 0, time() - 3600);
      setcookie("hash", 0, time() - 3600);

      unset($_SESSION["id"]);
      unset($_SESSION["pass"]);
      unset($_SESSION["hash"]);

      return true;
   }


   /**
    * Verifies a username / password combination
    *
    * @param $username String containing the username
    * @param $password String containing the password
    * @return int User ID on success, error code otherwise
    */
   protected static function _verify($username, $password) {
      global $xDb;

      if (!XValidate::isSimpleChars($username)) {
         return -1;
      }

      // Database query
      $query = "SELECT id, yubikey, password, salt, dt_login, login_attempts " .
               "FROM #__users                                                " .
               "WHERE username LIKE BINARY :username                         ";

      // Data retrieval
      $stmt = $xDb->prepare($query);
      $stmt->bindParam(":username", $username, PDO::PARAM_STR);
      $stmt->execute();

      if (!$auth = $stmt->fetch(PDO::FETCH_OBJ)) {
         return -1;
      }


      /*******************
       * LOCKED ACCOUNTS *
       *******************/
      $timeConstraint = time() - strtotime($auth->dt_login) < XConfig::get("AUTH_LOCKTIME");
      $countConstraint = $auth->login_attempts >= XConfig::get("AUTH_MAX_ATTEMPTS");

      if ($timeConstraint && $countConstraint) {
         return -2;
      }


      /**************************
       * METHOD 1 :: DB Details *
       **************************/
      if (self::hash($password, $auth->salt) == $auth->password) {
         return $auth->id;
      }

      /***********************
       * METHOD 2 :: YUBIKEY *
       ***********************/
      if (XConfig::get("AUTH_YUBI_ENABLED") && $auth->yubikey) {

         if (XConfig::get("AUTH_YUBI_API") && XConfig::get("AUTH_YUBI_KEY")) {

            $yubikey = new Yubikey(XConfig::get("AUTH_YUBI_API"), XConfig::get("AUTH_YUBI_KEY"));
            if ($yubikey->verify($password)) {
               return $auth->id;
            }

         } else {

            trigger_error("XAuthentication :: Yubikey not configured", E_USER_WARNING);

         }

      }

      return 0;
   }


   /**
    * Generates a random hash based on the given password and salt
    *
    * @param $password The password to use for the hash
    * @param $salt The salt to use for the hash (optional)
    * @return String The generated hash
    */
   public static function hash($password, $salt = null) {

      if (!CRYPT_BLOWFISH) {
         trigger_error("XAuthentication :: Blowfish unavailable in crypt()", E_USER_ERROR);
      }

      if (is_null($salt)) {
         $salt = substr(md5(uniqid(rand(), true)), 0, 21);
      }

      return crypt($password, "$2a$08$" . $salt . '$');
   }

}
?>