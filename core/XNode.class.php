<?php

/**
 * Node class for XTree (can hold various attributes with information)
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 * @see        XTree
 */
class XNode {

   /**
    * The level of this node in the tree
    * @var Int
    */
   var $level = 0;


   /**
    * The ID of this node
    * @var Int
    */
   var $xid = 0;


   /**
    * The ordering of this node in the tree
    * @var Int
    */
   var $ordering = 0;


   /**
    * List of all children of the this node
    * @var Array
    */
   var $children = array();


   /**
    * Creates a new XNode for XTree usage
    *
    * @param $data Object containing required data for XNode
    * @throws Exception Thrown if data does not contain required data
    */
   function __construct($data) {

      if (!isset($data->xid)) {
         throw new Exception("[XNode] No node ID (xId) found.");
      }

      if (!isset($data->parent_id)) {
         throw new Exception("[XNode] No parent ID found.");
      }

      if (!isset($data->ordering)) {
         throw new Exception("[XNode] No ordering found.");
      }

      foreach ($data as $attrib => $value) {

         if (is_object($value)) {

            // Only allow simple data structures
            //trigger_error("[XNode] Unexpected Object ignored.", E_USER_WARNING);
            print_r($value);
            //continue;

         }

         $this->$attrib = $value;
      }

   }


   /**
    * Returns amount of children
    *
    * @return int The amount of children found
    */
   public function count() {
      return count($this->children);
   }


   /**
    * Adds a child XNode to this XNode
    *
    * @param $node The XNode that should be added as child
    */
   protected function _add(XNode &$node) {

      $this->children[] = $node;
      $node->level  = $this->level + 1;
      $node->parent = &$this;

   }


   /**
    * Sorts the children of this XNode by attribute 'ordering' using QuickSort
    *
    * @param $node The XNode to start sorting at (default: this XNode)
    * @param $doDeepScan Toggles deepscan sorting (sorting of childs)
    */
   protected function sort(XNode $node = null, $doDeepScan = true) {

      $node = $node ? $node : $this;
      $node->children = $this->_quickSort($node->children);

      if ($doDeepScan) {

         foreach ($node->children as $child) {
            $this->sort($child);
         }

      }

   }


   /**
    * Sorts an Array of XNodes by variable 'ordering' using QuickSort
    *
    * @param $list Array containing XNodes to sort
    * @return Array Sorted list of XNodes
    */
   protected function _quickSort($list) {

      // No sorting required
      if (count($list) < 2) {
         return $list;
      }

      $x = $z = array();
      $y = array_shift($list);

      foreach ($list as $node) {

         if ($node->ordering < $y->ordering) {
            $x[] = $node;
            continue;
         }

         if ($node->ordering > $y->ordering) {
            $z[] = $node;
            continue;
         }

         trigger_error("[XNode] Duplicate: {$node->id}.", E_USER_WARNING);

      }

      return array_merge(
         $this->_quickSort($x), array($y), $this->_quickSort($z)
      );

   }


   /**
    * Returns first occurence of XNode by node ID (uses depth-first search)
    *
    * @param $id Integer with the node ID to search for
    * @return The requested XNode or null if not found
    */
   public function getItemById($id) {

      if ($this->xid == $id) {
         return $this;
      }

      foreach ($this->children as $child) {

         if ($node = $child->getItemById($id)) {
            return $node;
         }

      }

      return null;
   }


   /**
    * Returns first occurence of XNode by given field (uses depth-first search)
    *
    * @param $field The field to search
    * @param $value The value to look for
    * @return The requested XNode or null if not found
    */
   public function getItemByAttribute($attrib, $value) {

      if ($this->$attrib == $value) {
         return $this;
      }

      foreach ($this->children as $child) {

         if ($node = $child->getItemByAttribute($attrib, $value)) {
            return $node;
         }

      }

      return null;
   }


   /**
    * Returns the maximum value for a certain field
    *
    * @return int Maximum value found or 0
    */
   public function getMaximum($attrib, $deepScan = true) {

      if (!isset($this->children) || !count($this->children || !$deepScan)) {
         return $this->$attrib;
      }

      $max = $this->$attrib;
      foreach ($this->children as $child) {

         $otherMax = $child->getMaximum($attrib, $deepScan);
         $max = ($otherMax < $max) ? $max : $otherMax;

      }

      return $max;
   }


   /**
    * Returns the maximum ordering in use
    *
    * @return int Maximum ordering found or 0
    */
   public function getMaxOrdering() {

      if (!isset($this->children) || !count($this->children)) {
         return 0;
      }

      foreach ($this->children as $child) {
         $max = max(isset($max) ? $max : 0, $child->ordering);
      }

      return $max;
   }


   /**
    * Returns XNode (and children) as a JSON Object
    */
   public function encode() {
      return json_encode($this);
   }


   /**
    * Shows XNode (and children) as JSON Object
    */
   public function show() {

      header("Content-type: application/x-json");
      die($this->encode());

   }


   /**
    * Enables correct cloning of the XNode
    */
   public function __clone() {

      $this->parent = null;

      foreach ($this->children as $key => $child) {

         $this->children = $key ? $this->children : array();
         $this->_add(clone $child);

      }

   }

}
?>