<?php

/**
 * Parses all links to SEF variants (if applicable)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class parse_links {

   /**
    * The type of the plugin
    * @var String
    */
   public $type = "parse";


   /**
    * Creates a new instance of the plugin
    */
   public function parse_links() {
   }


   /**
    * Parses the given text
    *
    * @param $str The text to parse
    * @return String The parsed text with replaced links
    */
   public static function parse($str) {

      if (!XConfig::get("SEO_LINKS")) {
         return $str;
      }

      // Find all links, replace if possible
      if (preg_match_all("/<a(.*)>/U", $str, $matches)) {

         $originals = array();
         $links = array();

         $list = $matches[1];
         foreach ($list as $link) {

            $regex = '#([^\s=]+)\s*=\s*(\'[^<\']*\'|"[^<"]*")#';
            if (!preg_match_all($regex, $link, $matches, PREG_SET_ORDER)) {
               continue;
            }

            $attribs = (Object)array();
            foreach ($matches as $attr) {
               $attribs->$attr[1] = $attr[2];
            }

            // Only parse links with complete information
            if (!isset($attribs->href) || !isset($attribs->title)) {
               continue;
            }

            // Prepare parameters
            $name = trim($attribs->title);
            $href = preg_replace('/["\']/', '', $attribs->href);
            $link = html_entity_decode($href, ENT_QUOTES, "UTF-8");

            // Relative internal link
            if (strpos($link, 'index.php') === 0) {

               $links[] = XLinkFactory::create($link, 0, $name);
               $originals[] = $href;
               continue;

            }

            // Absolute internal link
            if (strpos($link, $xConf->baseURL) === 0) {

               $links[] = XLinkFactory::create($link, 0, $name);
               $originals[] = $href;
               continue;

            }

         }

         $str = str_replace($originals, $links, $str);

      }

      return $str;
   }

}
?>