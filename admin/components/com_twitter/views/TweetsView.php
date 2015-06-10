<?php

/**
 * View for Tweets
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class TweetsView extends XJSONView {

   protected function _init() {
      $this->_model = $this->_model->_list;
   }

}
?>