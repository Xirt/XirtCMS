<?php

/**
 * Shows a tagcloud based on the popularity of search terms
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class mod_tagcloud extends XModule {

   /**
    * Shows the content
    */
   function showNormal() {

      $terms = $this->_getTerms($this->xConf->terms_count);
      $terms = $this->_groupTerms($terms, $this->xConf->group_count);

      foreach ($terms as $key => $term) {

         $terms[$key]->link = XLinkFactory::create($term->uri, 0, null, $term->term);
         $terms[$key]->term = XTools::encodeHTML($term->term);

      }

      // Show template
      $tpl = new XTemplate($this->_location());
      $tpl->assign("xConf", $this->xConf);
      $tpl->assign("termList", $terms);
      $tpl->display("templates/template.tpl");

   }


   /**
    * Returns the requested terms from the database
    *
    * @param $count The number of search terms to extract
    * @return Array The list with search terms
    */
   private function _getTerms($count) {
      global $xDb;

      // Database query
      $query = "SELECT *                 " .
               "FROM #__search           " .
               "WHERE language = :iso    " .
               "ORDER BY impressions DESC";

      // Retrieve data
      $stmt = $xDb->prepare($query);
      $stmt->bindValue(":iso", XConfig::get("SESSION_LANGUAGE"));
      $stmt->execute();

      return $stmt->fetchAll(PDO::FETCH_OBJ);

   }


   /**
    * Returns the requested terms from the database
    *
    * @return Array The list with terms
    */
   private function _groupTerms($terms, $count) {

      // Sort & catch empty arrays
      if (!$terms = $this->_sortTerms($terms)) {
         return array();
      }

      // Define group means
      $maxValue   = end($terms)->impressions;
      $minValue   = reset($terms)->impressions;
      $variance   = ($maxValue - $minValue) / $count;
      $groupMeans = range($minValue, $maxValue, $variance);

      // Add items to groups
      $groups = array();
      foreach ($terms as $term) {

         $term->group = 0;
         $difference = $maxValue;

         for($n = 0; $n < count($groupMeans); $n++) {

            if (max(0, $term->impressions - $groupMeans[$n]) < $difference) {

               $difference = $term->impressions - $groupMeans[$n];
               $term->group = $n;

            }

         }

      }

      shuffle($terms);
      return $terms;

   }


   /**
    * Returns the requested terms from the database
    *
    * @return Array The list with terms
    */
   private function _sortTerms($terms) {

      usort($terms, array("mod_tagcloud", "_sort"));
      return $terms;

   }


   /**
    * Search method for method _sortTerms()
    *
    * @param a First term to compare
    * @param b First term to compare
    * @return int Comparison result: a < b: -1, a = b: 0, a > b: +1
    */
   protected static function _sort($a, $b) {
      return $a->impressions - $b->impressions;
   }

}
?>