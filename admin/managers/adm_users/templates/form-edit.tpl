<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='x_rank'>{$xLang->labels['rank']}</label>
      {html_options id=x_rank name=x_rank options=$ranks}

      <br />

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' id='x_name' name='x_name' value='' class='required' />

      <br />

      <label for='x_mail'>{$xLang->labels['mail']}</label>
      <input type='text' id='x_mail' name='x_mail' value='' class='required validate-email' />

      <br />

      <label for='x_editor'>{$xLang->labels['editor']}</label>
      {html_options id=x_editor name=x_editor options=$xLang->options['editors']}

      <br />

      <label for='x_yubikey'>{$xLang->labels['yubikey']}</label>
      <input type='text' id=x_yubikey name='x_yubikey' value='' class='validate-alphanum' maxlength='12' />

      <input type='hidden' name='content' value='adm_users' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='id' value='' />

   </fieldset>

   </form>

</div>
