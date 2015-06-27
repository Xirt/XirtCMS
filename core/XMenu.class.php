<?php

/**
 * Extended version of XTree to add extra menu functionality
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2015
 * @package    XirtCMS
 * @see        XTree
 */
class XMenu extends XTree {

   /**
    * Toggle indicating first initialization
    * @var boolean
    */
   private $_initialized = false;


   /**
    * Creates a new XMenu
    *
    * @param $id The ID of the menu
    * @param $title The title of the menu (optional, defaults null)
    */
   function __construct($id, $title = null, $language = null, $sitemap = true) {

      // Set requested language
      $this->language = $language;
      if (!(new LanguageList())->get($language)) {
         $this->language = XConfig::get("SESSION_LANGUAGE");
      }

      $this->id       = $id;
      $this->title    = $title;
      $this->sitemap  = $sitemap;

   }


   /**
    * Loads the menu details
    */
   public function load() {

      // Prevent duplicate work
      if ($this->_initialized) {
         return false;
      }

      // Create menu-tree structure
      foreach ($this->_getNodes() as $node) {
         $this->add($node);
      }

      $this->_activate();
      return ($this->_initialized = true);

   }


   /**
    * Return all published nodes from the DB
    *
    * @return Array Containing all published nodes
    */
   private function _getNodes() {
      global $xDb, $xUser;

      $languages = (new LanguageList())->toArray();
      $published = defined("_ADMIN") ? "%" : "1";
      $iso = $languages[XConfig::get("SESSION_LANGUAGE")]->preference;

      // Query (selection)
      $query = "SELECT *                                              " .
                "FROM (%s) AS subset                                  " .
                "WHERE menu_id = :id                                  " .
                "  AND published LIKE :published                      " .
                "  AND access_min <= :rank                            " .
                "  AND access_max >= :rank                            " .
                "GROUP BY xid                                         " .
                "ORDER BY parent_id ASC, xid ASC                      ";

      // Subquery (translations)
      $trans = "SELECT t1.*, t2.preference                            " .
               "FROM #__menunodes AS t1                               " .
               "INNER JOIN #__languages AS t2 ON t1.language = t2.iso " .
               "ORDER BY replace(t2.preference, :iso, 0)              ";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(":published", $published);
      $stmt->bindParam(":rank", $xUser->rank, PDO::PARAM_INT);
      $stmt->bindParam(":iso", $iso, PDO::PARAM_STR);
      $stmt->bindParam(":id", $this->id, PDO::PARAM_INT);
      $stmt->execute();

      // Create list
      $list = array();
      while ($nodeInfo = $stmt->fetch(PDO::FETCH_OBJ)) {

         $nodeInfo->link = XLinkFactory::create(
            $nodeInfo->link,
            $nodeInfo->xid,
            $nodeInfo->language,
            $nodeInfo->name
         )->toString();

         $list[] = new XMenuNode($nodeInfo);

      }

      return $list;
   }


   /**
    * Turns current item into active item
    */
   protected function _activate() {

      if ($node = $this->getItemById(XSession::$PAGE_ID)) {

         if (isset($node->link)) {
            $this->setActiveByLink($node->link);
         }

         return $node->setActive();

      }

      $this->setActiveByLink("index.php?" . $_SERVER["QUERY_STRING"]);

   }


   /**
    * Dummy method to stop activation process
    *
    * @return boolean true
    */
   public function setActive() {
      return true;
   }


   /**
    * Search depth-first for XMenuNode for the given link and activate it
    *
    * @param $link The link (of the active item) to search for
    */
   public function setActiveByLink($link) {

      foreach ($this->children as $child) {
         $child->setActiveByLink($link);
      }

   }

}
?>