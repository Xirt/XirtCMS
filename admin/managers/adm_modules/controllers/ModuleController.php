<?php

/**
 * Controller for XirtCMS Module
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ModuleController extends XController {

   /**
    * The location of the module files
    * @var String
    */
   const PATH_MODULE = "%s/modules/%s/";


   /**
    * Method executed on initialization to load Model
    */
   protected function _init() {

      $actions = array(
         "show", "showDetails", "edit", "editAccess", "toggleMobile",
         "toggleStatus", "delete"
      );

      $this->_model = new $this->_model;
      if (in_array($this->_action, $actions)) {

         // Load existing data
         $this->_model->load(XTools::getParam("id", 0, _INT));
         if (!isset($this->_model->id)) {

            trigger_error("[Controller] Module not found", E_USER_NOTICE);
            exit;

         }

      }

   }


   /**
    * Shows the data in the Model
    */
   protected function show() {
      $this->_model->set("config", "", true);
   }


   /**
    * Shows the data in the Model
    */
   public function showDetails() {

      $this->_model->set("ordering", null, true);
      $this->_model->set("position", null, true);
      $this->_model->set("pages", null, true);
      $this->_model->setConfiguration();

   }


   /**
    * Adds the data in the Model
    */
   protected function add() {

      $list = new ModulesModel();
      $this->_model->set("xid",      $list->getMaximum() + 1);
      $this->_model->set("type",     XTools::getParam("nx_type"));
      $this->_model->set("name",     XTools::getParam("nx_name"));
      $this->_model->set("language", XTools::getParam("nx_language"));

      $path = sprintf(self::PATH_MODULE, XConfig::get("SESSION_DIR_BASE"), $this->_model->type);
      $file = new XFile($path, "index.mod.xml");

      if ($file->readable()) {

         $this->_model->resetConfiguration();
         $this->_model->add();

      }

   }


   /**
    * Modifies the data in the Model
    */
   protected function edit() {

      if (!XTools::getParam("affect_all")) {

         $type = $this->_model->type;
         $config = XModule::getConfiguration($type);

         foreach ($config as $name => $details) {

            $value = XTools::getParam("xvar_" . $name);
            $this->_model->config->$name = trim($value);

         }

         $this->_model->set("name", XTools::getParam("x_name"));
         $this->_model->save();

      }

   }


   /**
    * Modifies the access data in the Model
    */
   protected function editAccess() {

      if (!XTools::getParam("affect_all")) {

         $this->_model->set("access_min", XTools::getParam("access_min", 0, _INT));
         $this->_model->set("access_max", XTools::getParam("access_max", 0, _INT));
         $this->_model->save();

      }

   }


   /**
    * Toggles the publication status for the Model
    */
   protected function toggleStatus() {

      $value = !intval($this->_model->published);
      $this->_model->set("published", $value);
      $this->_model->save();

   }


   /**
    * Deletes the data in the Model
    */
   protected function delete() {
      $this->_model->delete();
   }

}
?>