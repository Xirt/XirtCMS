<?php

/**
 * Class used for creation of instances of Twitter Tweets
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class Tweet {

   /**
    * The GUID of the Tweet
    * @var int
    */
   var $id = 0;


   /**
    * The account of the author of the Tweet
    * @var String
    */
   var $account = null;


   /**
    * The author of the Tweet
    * @var String
    */
   var $author = null;


   /**
    * String with the location of the avatar of the author of the Tweet
    * @var String
    */
   var $avatar = null;


   /**
    * The content / text of the Tweet
    * @var String
    */
   var $content = null;


   /**
    * The creation date of the Tweet
    * @var DateTime
    */
   var $created = null;


   /**
    * Creates a new tweet with the given information
    *
    * @param $guid The GUID of the Tweet
    * @param $account The account of the author of the Tweet
    * @param $author The author of the Tweet
    * @param $avatar The avatar of the author of the Tweet
    * @param $content The content / text of the Tweet
    * @param $created The creation date of the Tweet
    * @param $doLink Toggles the activation of links (default: false)
    */
   function __construct($guid, $account, $author, $avatar, $content, $created, $doLink = false) {

      $this->id       = $guid;
      $this->account  = $account;
      $this->author   = $author;
      $this->avatar   = $avatar;
      $this->content  = $doLink ? $this->_link($content) : $content;
      $this->created  = new DateTime($created);
   }


   /**
    * Create HTML-links from textual links and hashtags in given string
    *
    * @param $str The input string to convert
    * @return String with all links / hashtags as HTML-links
    */
   function _link($str) {

   	  $str = preg_replace("#(^|[\n ])([\w]+?://[\w]+[^ \"\n\r\t< ]*)#", "\\1<a href=\"\\2\" target=\"_blank\">\\2", $str);
      $str = preg_replace("#(^|[\n ])((www|ftp)\.[^ \"\t\n\r< ]*)#", "\\1<a href=\"http://\\2\" target=\"_blank\">\\2", $str);
      $str = preg_replace("/@(\w+)/", "<a href=\"http://www.twitter.com/\\1\" target=\"_blank\">@\\1</a>", $str);
   	  $str = preg_replace("/#(\w+)/", "<a href=\"http://search.twitter.com/search?q=\\1\" target=\"_blank\">#\\1</a>", $str);

   	  return $str;
   }


   /**
    * Saves the tweet to the database (if not saved yet)
    */
   public function save() {
      global $xDb;

      $created = $this->created->format("Y-m-d H:i:s");

      // Database query
      $query = "INSERT IGNORE INTO #__twitter
                SET id      = :id,
                    account = :account,
                    author  = :author,
                    avatar  = :avatar,
                    content = :content,
                    created = :created";

      // Save data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(":account", $this->account, PDO::PARAM_STR);
      $stmt->bindValue(":content", $this->content, PDO::PARAM_STR);
      $stmt->bindValue(":author", $this->author, PDO::PARAM_STR);
      $stmt->bindValue(":avatar", $this->avatar, PDO::PARAM_STR);
      $stmt->bindValue(":created", $created, PDO::PARAM_STR);
      $stmt->bindValue(":id", $this->id, PDO::PARAM_STR);
      $stmt->execute();

   }

}
?>