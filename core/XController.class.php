<?php

/**
 * Default Controller for XirtCMS
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class XController {

   /**
    * The Model for this Controller
    * @var Object
    */
   protected $_model = null;


   /**
    * The View for this Controller
    * @var Object
    */
   protected $_view = null;


   /**
    * Initializes the Controller
    *
    * @param $model The Model to use (optional, default null)
    * @param $view The View to use (optional, default null)
    * @param $action The action to execute (optional, default 'show')
    */
   function __construct($model = null, $view = null, $action = 'show') {

      $this->_model = $model;
      $this->_action = $action;
      $this->_view = $view;

      $this->_init();
      $this->$action();

   }

   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      if ($this->_model) {
         $this->_model = new $this->_model;
      }

   }


   /**
    * Show the model (default action)
    */
   protected function show() {

      if ($this->_model) {
         $this->_model->load();
      }

   }


   /**
    * Shows the given view on exit
    */
   public function __destruct() {

      if (!is_null($this->_view)) {
         $this->_view = new $this->_view($this->_model);
      }

   }

}
?>