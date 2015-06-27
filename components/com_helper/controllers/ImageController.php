<?php

/**
 * Controller for handling images
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class ImageController extends XController {

   /**
    * Creates a thumbnail from GET/POST data
    */
   protected function thumbnail() {
      new Thumbnail();
   }

}
?>