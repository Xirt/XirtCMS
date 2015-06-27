<?php

/**
 * Model for a complete sitemap
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 */
class SitemapModel extends XModel {

   /**
    * Method to load data
    */
   public function load() {

      $this->list = array();
      foreach ((new XMenuList())->toArray() as $menu) {

         if ($menu->sitemap) {

            $menu->load();
            self::_link($menu);
            $this->list[] = $menu;

         }

      }

   }


   /**
    * Replaces database links in given XMenu with usable (SEF) links
    *
    * @param $node The node to modify
    */
   private static function _link($node) {

      foreach ($node->children as $key => $child) {

         // Skip hidden items / non-regular links
         if (!$child->sitemap || !in_array($child->link_type, array(0, 1, 2))) {

            unset($node->children[$key]);
            continue;

         }

         self::_link($child);

      }

   }


   /**
    * Filters the given array (removes items with identical links)
    *
    * @param $array The array to filter
    * return Array The filtered array
    */
   private static function _filter($array) {

      foreach ($array as $key => $item) {

         foreach ($array as $key2 => $item2) {

            if ($item->link == $item2->link && $key != $key2) {

               unset($array[$key]);
               break;

            }

         }

      }

      return $array;
   }


   /**
    * Returns all nodes in an Array
    *
    * @return Array Contains all the nodes
    */
   function toArray() {

      $nodes = array();
      foreach ($this->list as $menu) {
         $nodes = array_merge($nodes, $menu->toArray());
      }

      return $nodes;
   }

}
?>