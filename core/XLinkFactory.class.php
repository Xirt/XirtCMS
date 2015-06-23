<?php

/**
 * Utility Class for creating SEF links in content / template
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
abstract class XLinkFactory {

   /**
    * Internal list of links
    * @var XLinkList
    */
   protected static $_list = null;


   /**
    * Returns a link according to SEF settings
    *
    * @param $str The String to parse a URL
    * @param $pageId The unique (menuitem) ID of the page
    * @param $name The name for SEF variant for the link
    * @return XLink with details on the requested link
    */
   public static function create($str, $cId = 0, $name = "index") {

      if (self::$_list == null) {
         self::$_list = new XLinkList();
      }

      // Known link (identified as SEF variant)
      if ($link = self::$_list->returnLinkByAlternative($str)) {
         return $link;
      }

      // Known link (identified as original)
      $iso = XConfig::get("SESSION_LANGUAGE");
      if ($link = self::$_list->returnLinkByQuery($str, $iso)) {
         return $link;
      }

      if (self::_isSEF($str)) {

         // Unknown link (original)
         $link = new XLink(null, $str);
         $link->create(null, $cId, $iso);
         self::$_list->add($link);

      } else {

         // Uknown link (SEF variant)
         $link = new XLink($str, null);
         $link->create($name, $cId, $iso);
         self::$_list->add($link);

      }

      return $link;
   }


   /**
    * Parses original link and returns formatted query
    *
    * @param $str The String to parse a URL
    * @return True if the String is a URL with query, false otherwise
    */
   private static function _isSEF($str) {
      return (!($uri = parse_url($str)) || !array_key_exists('query', $uri));
   }

}
?>