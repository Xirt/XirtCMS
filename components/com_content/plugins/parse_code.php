<?php

/**
 * Parses all "PRE"-tags to display as code
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class parse_code {

   /**
    * The type of the plugin
    * @var String
    */
   public $type = "parse";


   /**
    * Creates a new instance of the plugin
    */
   public function parse_code() {
   }


   /**
    * Parses the given text
    *
    * @param $str The text to parse
    * @return String The parsed text ("PRE"-tags replaced by CODE-list)
    */
   public function parse($str) {

      preg_match_all("#<pre>(.+?)</pre>#is", $str, $matches);

      // Loop through all 'pre' instances
      for ($i = 0; $i < count($matches[0]); $i++) {

         $lines = preg_split("/\r\n|\n|\r/", $matches[1][$i]);
         for ($j = 0; $j < count($lines); $j++) {
            $lines[$j] = "<li><code>" . $lines[$j] . "</code></li>";
         }

         $str = str_replace($matches[0][$i], "<ol class='code'>" . implode("\n", $lines) . "</ol>", $str);

      }

      return $str;

   }

}

?>