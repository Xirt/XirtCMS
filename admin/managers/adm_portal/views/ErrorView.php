<?php

/**
 * View for the management panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class ErrorView extends XView {

   /**
    * Shows the model on destruction
    */
   function __destruct() {

      // FIXME :: Should use Smarty template
      foreach ($this->_model->entries as $entry) {
         print($entry . "<br />");
      }

   }

}
?>