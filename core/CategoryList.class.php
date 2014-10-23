<?php

/**
 * List containing all content categories
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class CategoryList {

   /**
    * Internal list containing all items
    * @var Array
    */
   private static $_list = array();


   /**
    * Toggle indicating first initialization
    * @var boolean
    */
   private static $_initialized = false;


   /**
    * Creates a new CategoryList
    *
    * @param $forceRefresh Toggles a refresh even if data was cached (default: false)
    */
   public function __construct($forceRefresh = false) {

      if (!self::$_initialized || $forceRefresh) {
         $this->_init();
      }

      self::$_initialized = true;

   }


   /**
    * Loads all categories from the database
    *
    * @param $iso The language to load (optional)
    */
   public function _init($iso = null) {
      global $xDb;

      $languageList = (new LanguageList)->toArray();
      $iso = array_key_exists($iso, $languageList) ? $iso : XConfig::get("SESSION_LANGUAGE");
      $iso = intval($languageList[$iso]->preference);

      // Query (selection)
      $query = "SELECT id, xid, parent_id, name, ordering, language   " .
                "FROM (%s) AS subset                                  " .
                "GROUP BY xid                                         " .
                "ORDER BY level ASC, ordering DESC                    ";

      // Subquery (translations)
      $trans = "SELECT t1.*                                           " .
               "FROM #__content_categories AS t1                      " .
               "INNER JOIN #__languages AS t2 ON t1.language = t2.iso " .
               "ORDER BY replace(t2.preference, :iso, 0)              ";

      // Retrieve data
      $stmt = $xDb->prepare(sprintf($query, $trans));
      $stmt->bindParam(":iso", $iso, PDO::PARAM_STR);
      $stmt->execute();

      // Populate object
      self::$_list = new XTree();
      while ($dbRow = $stmt->fetchObject()) {
         self::$_list->add(new XNode($dbRow));
      }

   }


   /**
    * Returns all available categories
    *
    * @param $includeIndex Toggles including of the index/key in the array
    * @return Array containing categories
    */
   public function toArray($includeIndex = true) {

       if ($includeIndex) {

          $list = array();
          foreach (self::$_list->toArray() as $category) {
             $list[$category->xid] = $category;
          }

          return $list;
       }

       return self::$_list->toArray();
   }


   /**
    * Returns list as a JSON Object
    */
   public function encode() {
      return json_encode(self::toArray(false));
   }


   /**
    * Shows list as JSON Object
    */
   public function show() {

      header("Content-type: application/x-json");
      die(self::encode());

   }

}
?>