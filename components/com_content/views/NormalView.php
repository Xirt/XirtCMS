<?php

/**
 * View for the normal version of the model
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class NormalView extends XComponentView {


   /**
    * The defaul template file to load
    * @var String
    */
   protected $_file = "version-normal.tpl";


   /**
    * Method executed on initialization
    */
   protected function _init() {

      // Modify page properties
      XPageInfo::addScript("components/com_content/templates/js/main.js");
      XPageInfo::addMetaTag("keywords", $this->_model->meta_keywords);
      XPageInfo::addMetaTag("description", $this->_model->meta_description);

      // Modify page title
      XPageInfo::extendTitle($this->_model->title);
      if (trim($this->_model->meta_title)) {
         XPageInfo::setTitle($this->_model->meta_title);
      }

      // Template
      parent::_init();
      $this->_template->assign("item", $this->_model);

   }

}
?>