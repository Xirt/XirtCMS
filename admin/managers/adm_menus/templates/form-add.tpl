<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='nx_title'>{$xLang->labels['title']}</label>
      <input type='text' id='nx_title' name='nx_title' value='' maxlength='128' class='required' />

      <br />

      <label for='nx_language'>{$xLang->labels['language']}</label>
      {html_options options=$languages name=nx_language id=nx_language}

      <input type='hidden' name='content' value='adm_menus' />
      <input type='hidden' name='task' value='add_item' />

   </fieldset>

   </form>

</div>