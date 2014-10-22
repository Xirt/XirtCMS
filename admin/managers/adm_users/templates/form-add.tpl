<div id='dvAdd' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='nx_rank'>{$xLang->labels['rank']}</label>
      {html_options id=nx_rank name=nx_rank options=$ranks}

      <br />

      <label for='nx_username'>{$xLang->labels['username']}</label>
      <input type='text' id='nx_username' name='nx_username' value='' class='validate-simple' required />

      <br />

      <label for='nx_name'>{$xLang->labels['name']}</label>
      <input type='text' id='nx_name' name='nx_name' value='' required />

      <br />

      <label for='nx_mail'>{$xLang->labels['mail']}</label>
      <input type='email' id='nx_mail' name='nx_mail' value='' required />

      <br />

      <label for='nx_editor'>{$xLang->labels['editor']}</label>
      {html_options id=nx_editor name=nx_editor options=$xLang->options['editors']}

      <input type='hidden' name='content' value='adm_users' />
      <input type='hidden' name='task' value='add_item' />

   </fieldset>

   </form>

</div>
