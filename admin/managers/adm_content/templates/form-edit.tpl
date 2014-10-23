<div id='dvItem' style='display: none;'>

<form action='index.php' method='post' class='xForm'>

   <div class='box-editor'>{$editor = XTools::showEditor('x_content')}</div>

   <div class='column-right' id='xOptions'>

      <h4 class='ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix'>
         {$xLang->headers['optionsItem']}
      </h4>
      <div class='box-option'>

         <label for='x_title'>{$xLang->labels['title']}</label>
         <input type='text' id='x_title' name='x_title' value='' maxlength='128' class='required' />

         <br />

         <label for='x_category'>{$xLang->labels['category']}</label>
         <select id='x_category' name='x_category'>
            <optgroup label='{$xLang->misc['optDefault']}'>
               <option value='0'>{$xLang->misc['noCategory']}</option>
            </optgroup>
            <optgroup label='{$xLang->misc['optCategories']}' id='x_category'></optgroup>
         </select>

         <br />

         <label for='x_meta_title'>{$xLang->labels['meta_title']}</label>
         <input type='text' id='x_meta_title' name='x_meta_title' value='' maxlength='128' />

      </div>

      <br />

      <h4 class='ui-dialog-titlebar ui-widget-header ui-corner-top ui-helper-clearfix'>
         {$xLang->headers['optionsSEO']}
      </h4>
      <div class='box-option meta'>

         <label for='x_meta_keywords'>{$xLang->labels['meta_keywords']}</label>
         <textarea id='x_meta_keywords' name='x_meta_keywords' rows='3' cols='50' class='maxLength:256'></textarea>

         <br />

         <label for='x_meta_description'>{$xLang->labels['meta_description']}</label>
         <textarea id='x_meta_description' name='x_meta_description' rows='3' cols='50' class='maxLength:256'></textarea>

      </div>

      <input type='hidden' name='content' value='adm_content' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='xid' value='' />
      <input type='hidden' name='id' value='' />

   </div>

</form>

</div>