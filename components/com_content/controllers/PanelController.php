<?php

/**
 * Controller for the panel
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class PanelController extends XController {

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $this->_model = new $this->_model;
      if (in_array($this->_action, array("show", "send"))) {
         $this->_ready = $this->_model->load(XTools::getParam("id", 0, _INT));
      }

   }


   /**
    * Tracks status of this controller / model combination
    * @var boolean
    */
   private $_ready = false;


   /**
    * Show the model (default action)
    */
   protected function show() {

      if ($this->_ready) {

         // Parse text using plugins
         foreach (ContentHelper::getPlugins() as $plugin) {

            if ($plugin->type = "parse") {
               $this->_model->content = $plugin->parse($this->_model->content);
            }

         }

      }

   }


   /**
    * Shows the given view on exit
    */
   function __destruct() {

      if (!is_null($this->_view) && $this->_ready) {
         return ($this->_view = new $this->_view($this->_model));
      }

      Xirt::pageNotFound();

   }

}
?>