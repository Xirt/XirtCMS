<?php

include_once("classes/RSSFeed.php");
include_once("classes/RSSItem.php");

/**
 * Module to show RSS-feed on the website
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class mod_rssfeed extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      $feed = $this->_getFeed();

      if ($items = $feed->toArray($this->xConf->limit)) {

         $tpl = new XTemplate($this->_location());
         $tpl->assign("xConf", $this->xConf);
         $tpl->assign("xLang", $this->xLang);
         $tpl->assign("items", $items);
         $tpl->display("templates/template.tpl");

      }

   }

   /**
    * Returns the given RSS Feed
    *
    * @return RSSFeed The requested RSSFeed object
    */
   private function _getFeed() {

      $feed = new RSSFeed($this->xConf->feed, $this->xConf->cache);
      $feed->parse();

      return $feed;
   }

}
?>