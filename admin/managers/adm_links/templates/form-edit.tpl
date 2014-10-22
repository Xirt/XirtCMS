<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='x_alternative'>{$xLang->labels['alternative']}</label>
      <input type='text' id='x_alternative' name='x_alternative' value='' class='required' />

      <br />

      <label for='x_query'>{$xLang->labels['query']}</label>
      <input type='text' id='x_query' name='x_query' value='' class='required' />

      <br />

      <label for='x_cid'>{$xLang->labels['cid']}</label>
      <input type='text' id='x_cid' name='x_cid' value='' class='required digits' />

      <input type='hidden' name='content' value='adm_links' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='iso' value='' />
      <input type='hidden' name='id' value='' />

   </fieldset>

   </form>

</div>
