<?php

/**
 * Class for keeping data on items of an RSS feed
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 * @see        RSSFeed
 */
class RSSItem {

   /**
    * The title of the item
    * @var String
    */
   public $title = null;


   /**
    * The description of the item
    * @var String
    */
   public $description = null;


   /**
    * The link to the item
    * @var String
    */
   public $location = null;


   /**
    * The creation date of the item
    * @var DateTime
    */
   public $created = null;


   /**
    * Creates a new instance of RSSItem
    *
    * @param $title The title of the item
    * @param $content The description of the item
    * @param $location The link to the item
    * @param $created The creation date of the item
    */
   function __construct($title, $description, $location, $created) {

      $this->title       = $title;
      $this->description = $description;
      $this->location    = $location;
      $this->created     = new DateTime($created);

   }

}
?>