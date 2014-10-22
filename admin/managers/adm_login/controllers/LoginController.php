<?php

/**
 * Controller for Login Sessions
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class LoginController extends XController {

   /**
    * Attempt to login using the Model
    */
   protected function login() {
      global $xCom;

      $user = XTools::getParam("user_name");
      $pass = XTools::getParam("user_pass");

      switch (XAuthentication::create($user, $pass)) {

         case 0:
         case -1:
            die($xCom->xLang->messages["loginFail"]);
            break;

         case -2:
         	die($xCom->xLang->messages["accountLocked"]);
         	break;

         default:
            break;

      }

   }


   /**
    * Attempts to logout using the Model
    */
   protected function logout() {

      XAuthentication::destroy();
      header("Location: index.php");

   }

}
?>