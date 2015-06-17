<?php

/**
 * Class to load / save a tweets from / to the database
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class TweetList {

   /**
    * List with the parsed entries of the feed
    * @var Array
    */
   protected $_list = array();


   /**
    * The accounts represented in the list
    * @var Array
    */
   protected $_accounts = array();


   /**
    * Creates a new TweetList for the given accounts
    */
   function __construct($accounts) {
      $this->_accounts = $accounts;
   }


   /**
    * Selects all retrieved items from the DB
    *
    * @param $id The ID of the tweet to start at
    * @param $limit The number of tweets to load (maximum)
    */
   public function load($id = 0, $limit = 10) {
      global $xDb;

      // Database query
      $query  = "SELECT *              ".
                "FROM #__twitter       ".
                "WHERE published != 0  ".
                "  AND (account='%s')  ".
                "  AND id > :id        ".
                "ORDER BY created DESC ".
                "LIMIT 0, %s           ";
      $query = sprintf($query, $this->_getQuery(), $limit);

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(":id", "10", PDO::PARAM_STR);
      $stmt->execute();

      // Populate instance
      while ($dbRow = $stmt->fetchObject()) {

         $this->_list[] = new Tweet(
            $dbRow->id,
            $dbRow->account,
            $dbRow->author,
            $dbRow->avatar,
            $dbRow->content,
            $dbRow->created
         );

      }

   }


   /**
    * Creates a search clausule for the query
    */
   private function _getQuery() {
      return implode("' OR account='", $this->_accounts);
   }


   /**
    * Saves the parsed items to the database
    */
   public function save() {

      foreach ($this->_list as $tweet) {
         $tweet->save();
      }

   }


   /**
    * Returns the current feed as an Array
    *
    * @return Array The current feed
    */
   public function toList() {
      return $this->_list;
   }


   /**
    * Returns the current feed as an Array
    *
    * @return Array The current feed
    */
   public function toJSON() {

      $format = XConfig::get("FORMAT_DATETIME");

      // Loop through tweets
      foreach ($this->_list as $tweet) {
         $tweet->created = $tweet->created->format($format);
      }

      return json_encode($this->_list);
   }


   /**
    * Shows the current feed in JSON format
    */
   public function show() {

      header("Content-type: application/x-json");
      die($this->toJSON());

   }

}
?>