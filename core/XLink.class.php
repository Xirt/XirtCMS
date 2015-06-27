<?php

/**
 * TODO :: Clean-up and finalize
 * Class holding information about a (SEF) link
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class XLink {

   /**
    * @var Array containing replaceable (special) characters
    */
   protected static $conversions = array (
      "Š" => "S", "š" => "s", "Đ" => "Dj", "đ" => "dj", "Ž" => "Z", "ž" => "z",
      "Č" => "C", "č" => "c", "Ć" => "C",  "ć" => "c",  "À" => "A", "Á" => "A",
      "Â" => "A", "Ã" => "A", "Ä" => "A",  "Å" => "A",  "Æ" => "A", "Ç" => "C",
      "È" => "E", "É" => "E", "Ê" => "E",  "Ë" => "E",  "Ì" => "I", "Í" => "I",
      "Î" => "I", "Ï" => "I", "Ñ" => "N",  "Ò" => "O",  "Ó" => "O", "Ô" => "O",
      "Õ" => "O", "Ö" => "O", "Ø" => "O",  "Ù" => "U",  "Ú" => "U", "Û" => "U",
      "Ü" => "U", "Ý" => "Y", "Þ" => "B",  "ß" => "Ss", "à" => "a", "á" => "a",
      "â" => "a", "ã" => "a", "ä" => "a",  "å" => "a",  "æ" => "a", "ç" => "c",
      "è" => "e", "é" => "e", "ê" => "e",  "ë" => "e",  "ì" => "i", "í" => "i",
      "î" => "i", "ï" => "i", "ð" => "o",  "ñ" => "n",  "ò" => "o", "ó" => "o",
      "ô" => "o", "õ" => "o", "ö" => "o",  "ø" => "o",  "ù" => "u", "ú" => "u",
      "û" => "u", "ý" => "y", "ý" => "y",  "þ" => "b",  "ÿ" => "y", "Ŕ" => "R",
      "ŕ" => "r", " " => "-"
   );

   /**
    * The unique (menuitem) ID of the page related to this link
    * @var int
    */
   public $cid  = 0;


   /**
    * The language of this link
    * @var String
    */
   public $iso = null;


   /**
    * The query of the original link
    * @var String
    */
   public $query = null;


   /**
    * The SEF version of the link
    * @var String
    */
   public $alternative = null;


   /**
    * Create a new link (optionally filled with given values)
    *
    * @param $alt The SEF version of the link
    * @param $pageId The unique (menuitem) ID of the page
    * @param $query The original version of the link
    * @param $iso The language of the link
    */
   function __construct($query = null, $alt = null, $pageId = 0, $iso = null) {

      $this->cid         = intval($pageId);
      $this->iso         = $iso;
      $this->query       = $query;
      $this->alternative = $alt;

   }


   /**
    * Fill this instance with the given values
    *
    * @param $name The name for SEF variant for the link
    * @param $query The original version of the link
    * @param $iso The language of the link
    */
   function create($name, $pageId = null, $iso = null) {

      // Create link name (simplify given name)
      $name = strtolower(htmlentities($name, ENT_COMPAT, "UTF-8"));
      $name = html_entity_decode($name, ENT_COMPAT, "UTF-8");
      $name = strtr($name, self::$conversions);
      $name = preg_replace("/[^\w-]/si", "", $name);

      // Determine language
      $iso = $iso ? $iso : $this->iso;
      $iso = $iso ? $iso : XConfig::get("SESSION_LANGUAGE");

      // Create alternative
      for ($i = 0; !$i || (new XLinkList())->returnLinkByAlternative($link); $i++) {

         // Numbering for duplicate terms
         $link = $i ? sprintf("%s-%d", $name, $i) : $name;

         // If not primary language, add language to link
         $languages = (new LanguageList())->toArray();
         if (array_shift($languages)->iso != $iso) {
            $link = sprintf("%s/%s", $iso, $link);
         }

      }

      // Store values
      $this->cid         = $pageId;
      $this->iso         = $iso;
      $this->alternative = $link;

   }


   /**
    * Saves the links to the database
    */
   public function save() {
      global $xDb;

      if ($this->alternative) {
         return $xDb->insert("#__links", $this);
      }

   }


   /**
    * Returns the link for this XLink
    *
    * @return String The link for the current session
    */
   public function toString() {
      return XConfig::get("SEO_LINKS") ?  $this->alternative : $this->query;
   }

}
?>