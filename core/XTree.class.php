<?php

/**
 * Class required for creating a tree datastructure
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package	   XirtCMS
 * @see        XNode
 */
class XTree extends XNode {

   /**
    * Overrides level of (extended) XNode
    * @var Int
    */
   var $level = 0;


   /**
    * Overrides node ID of (extended) XNode
    * @var Int
    */
   var $xid  = 0;


   /**
    * Holds the tree as an array (used as cache)
    * @var boolean
    */
   private $_tree = false;


   /**
    * Holds true when variable _tree is not up-to-date
    * @var boolean
    */
   private $_hasChanged = false;


   /**
    * CONSTRUCTOR (overrides XNode constructor)
    */
   function __construct() {
   }


   /**
    * Returns menu as an Object
    *
    * @return Object The tree as an Object
    */
   public function getTree() {
      return $this;
   }


   /**
    * Returns the XTree as an Array
    *
    * @return Array The XTree as an Array
    */
   public function toArray() {

      if ($this->_tree && !$this->_hasChanged) {
         return $this->_tree;
      }

      $this->_tree = $this->_toArray($this);
      $this->_hasChanged = false;

      return $this->_tree;

   }


   /**
    * Converts tree structure into an Array and returns it
    *
    * @param $node The XNode to convert
    * @return Array The XNode as an Array
    */
   private function _toArray($node) {

      $list = array();
      foreach ($node->children as $child) {
         $clone = clone $child;

         $list[] = $clone;
         $list = array_merge($list, $this->_toArray($child));

         // Remove / reset recursion data
         unset($clone->parent);

         $clone->children = null;
      }

      return $list;

   }


   /**
    * Attempts to add given XNode to this XTree
    *
    * @param node XNode to add to this XTree
    * @return boolean Returns true on success, false on failure
    */
   public function add(&$node) {

      // Add new 'branch' to root
      if (!$node->parent_id) {

         $this->_add($node);
         $this->sort(null, false);
         $this->_hasChanged = true;

         return true;

      }

      // Add new 'leaf' to tree
      if ($parentNode = $this->getItemById($node->parent_id)) {

         $parentNode->_add($node);
         $parentNode->sort(null, false);
         $this->_hasChanged = true;

         return true;

      }

      return false;

   }


   /*****************/
   /* MISCELLANEOUS */
   /*****************/

   /**
    * Returns XTree (and children) as a JSON Object
    *
    * @param $treeOnly Toggless returning of tree vs. the complete menu details
    */
   public function encode($treeOnly = true) {

      if ($treeOnly) {
         return json_encode($this->_tree);
      }

      return json_encode($this);

   }


   /**
    * Shows XTree (and children) as JSON Object
    *
    * @param $treeOnly Toggless returning of tree vs. the complete menu details
    */
   public function show($treeOnly = true) {

      if ($treeOnly) {

         header("Content-type: application/x-json");
         die(json_encode($this->_tree));

      }

      header("Content-type: application/x-json");
      die(json_encode($this));

   }


   /**
    * Enables the correct cloning of the XTree
    */
   public function __clone() {

      foreach ($this->children as $key => $child) {

         $this->children = $key ? $this->children : array();
         $this->_add(clone $child);

      }

   }

}
?>