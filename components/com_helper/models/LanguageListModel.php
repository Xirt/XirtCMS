<?php

/**
 * Models for a list of XirtCMS languages
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class LanguageListModel extends XModel {

   function load() {
      $this->_list = (new LanguageList)->toArray(true);
   }

}
?>