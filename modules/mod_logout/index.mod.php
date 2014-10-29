<?php

/**
 * Module to show a simple logout button
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class mod_logout extends XModule {

   /**
    * Handles any normal requests
    */
   public function showNormal() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign("xConf", $this->xConf);
      $tpl->assign("xLang", $this->xLang);
      $tpl->display("templates/template.tpl");

   }

}
?>