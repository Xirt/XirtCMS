<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='nx_rank'>{$xLang->labels['rank']}</label>
      {html_options options=$ranks id=nx_rank name=nx_rank}

      <br />

      <label for='nx_name'>{$xLang->labels['name']}</label>
      <input type='text' id='nx_name' name='nx_name' value='' maxlength='128' class='required' />

      <br />

      <label for='nx_language'>{$xLang->labels['language']}</label>
      {html_options options=$languages id=nx_language name=nx_language}

      <input type='hidden' name='content' value='adm_usergroups' />
      <input type='hidden' name='task' value='add_item' />

   </fieldset>

   </form>

</div>
