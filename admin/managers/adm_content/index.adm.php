<?php

/**
 * Manager for XirtCMS static content
 *
 * @author     A.G. Gideonse
 * @version    2.0
 * @copyright  XirtCMS 2010 - 2014
 * @package    XirtCMS
 */
class Manager extends XComponent {

   /**
    * Handles any normal requests
    */
   function showNormal() {
      new PanelController("PanelModel", "PanelView", "show");
   }

   /**
    * Handles any AJAX requests
    */
   function showAjax() {

      switch (XTools::getParam("task")) {

         /*
          * View methods
          */
         case "show_content_list":
            new ContentsController("ContentsModel", "ContentsView", "show");
            return;

         case "show_category_list":
			new CategoryListController("CategoryListModel", "CategoryListView", "show");
            return;

         case "show_item":
            new ContentController("ContentModel", "ContentView", "show");
            return;

         case "show_details":
            new ContentController("ContentModel", "ContentView", "showDetails");
            return;


         /*
          * Modify methods
          */
         case "add_content":
            new ContentController("ContentModel", null, "add");
            return;

         case "add_translation":
            new ContentListController("ContentListModel", null, "translate");
            return;

         case "edit_item":
            new ContentController("ContentModel", null, "edit");
            new ContentListController("ContentListModel", null, "edit");
            return;

         case "edit_config":
            new ContentController("ContentModel", null, "editConfiguration");
            new ContentListController("ContentListModel", null, "editConfiguration");
            return;

         case "edit_access":
            new ContentController("ContentModel", null, "editAccess");
            new ContentListController("ContentListModel", null, "editAccess");
            return;

         case "toggle_status":
            new ContentController("ContentModel", null, "toggleStatus");
            return;

         case "remove_item":
            new ContentController("ContentModel", null, "delete");
            return;

      }

   }

}
?>