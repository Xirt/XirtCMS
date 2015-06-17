<?php

include("TwitterRequest.php");

/**
 * Class to load / save a Twitter feed from the web
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2011 - 2015
 * @package    XirtCMS
 */
class TwitterFeed {

	/**
	 * String with base location of the feed
	 * @var String
	 */
	const FEED = "http://search.twitter.com/search.rss?q=";


	/**
	 * The loaded feed in its original DOM structure
	 * @var DOMDocument
	 */
	var $_feed = null;


	/**
	 * List with the parsed entries of the feed
	 * @var Array
	 */
	var $_list = array();


	/**
	 * Creates a new Twitterfeed instance for loading tweets
	 *
	 * @param $query The search query for the twitter feed
	 */
	function __construct($query) {
		$this->_init($query);
	}


	/**
	 * Initializes the feed by loading it in a DOMDocument object
	 *
	 * @param $query The search query for the Twitter feed
	 */
	private function _init($query) {

		$key    = XConfig::get("TWITTER_CONSUMER_KEY");
		$secret = XConfig::get("TWITTER_CONSUMER_SECRET");

		$feed = new TwitterRequest($key, $secret);
		$this->_feed = $feed->search($query);

	}


	/**
	 * Parses the current feed
	 *
	 * @return int The amount of parsed items
	 */
	public function parse() {

		foreach ($this->_getItems() as $item) {

			$this->_list[] = new Tweet(
				$item->id,
				$item->user->screen_name,
				$item->user->name,
				$item->user->profile_image_url,
				$item->text,
				$item->created_at,
				true
			);

		}

		return count($this->_list);
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
	 * Returns all items from the current feed
	 *
	 * @return Array The items in the feed
	 */
	private function _getItems() {

		if ($items = $this->_feed->statuses) {
			return $items;
		}

		return array();
	}


	/**
	 * Returns the requested attribute from the given item
	 *
	 * @param $item The item containing the requested attribute
	 * @param $attrib The requested attribute
	 * @return mixed Null on failure, the value on success
	 */
	private function _getValue($item, $attrib) {

		if ($item = $item->getElementsByTagName($attrib)) {
			return $item->item(0)->nodeValue;
		}

		return null;
	}


	/**
	 * Parses the GUID to a readable format (to String because of large numbers)
	 *
	 * @param $guid The GUID as given by the feed
	 * @return String The GUID as an integer value
	 */
	private function _parseGUID($guid) {

		// Save to array for E_STRICT
		$array = explode("/", $guid);

		return array_pop($array);
	}


	/**
	 * Parses the account to a readable format
	 *
	 * @param $author The account as given by the feed
	 * @return String The account as a String value
	 */
	private function _parseAccount($author) {
		return substr($author, 0, strpos($author, "@"));
	}


	/**
	 * Parses the author to a readable format
	 *
	 * @param $author The author as given by the feed
	 * @return String The author as a String value
	 */
	private function _parseAuthor($author) {
		return substr($author, strpos($author, "(") + 1, -1);
	}

}
?>