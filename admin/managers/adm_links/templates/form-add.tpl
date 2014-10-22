<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='nx_alternative'>{$xLang->labels['alternative']}</label>
      <input type='text' id='nx_alternative' name='nx_alternative' value='' class='required' />

      <br />

      <label for='nx_query'>{$xLang->labels['query']}</label>
      <input type='text' id='nx_query' name='nx_query' value='' class='required' />

      <br />

      <label for='nx_cid'>{$xLang->labels['cid']}</label>
      <input type='text' id='nx_cid' name='nx_cid' value='' class='required digits' />

      <br />

      <label for='nx_language'>{$xLang->labels['ISO']}</label>
      {html_options options=$languages id=nx_language name=nx_language}

      <input type='hidden' name='content' value='adm_links' />
      <input type='hidden' name='task' value='add_item' />

   </fieldset>

   </form>

</div>
