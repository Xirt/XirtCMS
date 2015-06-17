<?php

include_once("classes/Tweet.php");
include_once("classes/TweetList.php");
include_once("classes/TwitterFeed.php");

/**
 * Module to show Twitter feed on the website
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class mod_twitterfeed extends XModule {

   /**
    * Shows the content
    */
   public function showNormal() {

      $tpl = new XTemplate($this->_location());
      $tpl->assign("xConf", $this->xConf);
      $tpl->assign("xLang", $this->xLang);
      $tpl->display("templates/template.tpl");

   }


   /**
    * Shows the AJAX content
    */
   public function showAJAX() {

      // Update database
      $feed = new TwitterFeed($this->_getQuery());
      $feed->parse();
      $feed->save();

      // Show tweets from database
      $limit = $this->xConf->limit ? $this->xConf->limit : 10;
      $feed = new TweetList($this->_getAccounts());
      $feed->load(0, $limit);
      $feed->show();

   }


   /**
    * Returns the query for the Twitter feed (defined in settings)
    *
    * @return String The query for the Twitter feed
    */
   private function _getQuery() {
      return "+from:" . implode("+OR+from:", $this->_getAccounts());
   }


   /**
    * Returns the accounts represented in this Twitter feed
    *
    * @return Array List of the accounts
    */
   private function _getAccounts() {
      return explode(",", $this->xConf->accounts);
   }


   /**
    * Makes text links in the given text clickable
    *
    * @param $text The text to parse
    * @return String The text with clickable links
    */
   private function _linkify($text) {

      $pattern     = "(((f|ht){1}tp://)[-a-zA-Z0-9@:%_\+.~#?&//=]+)";
      $replacement = "<a href='\\1' rel='external'>\\1</a>";

      return eregi_replace($pattern, $replacement, $text);
   }

}
?>