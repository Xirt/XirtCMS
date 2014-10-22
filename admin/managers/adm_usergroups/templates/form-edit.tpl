<div id='dvItem' style='display: none;'>

   <form action='index.php' method='post' class='xForm'>

   <fieldset class='box-form'>

      <label for='x_rank'>{$xLang->labels['rank']} *</label>
      {html_options options=$ranks id=x_rank name=x_rank}

      <br />

      <label for='x_name'>{$xLang->labels['name']}</label>
      <input type='text' id='x_name' name='x_name' value='' maxlength='128' class='required' />

      <div class='box-affect'>

         * {$xLang->misc['affectAll']}

      </div>

      <input type='hidden' name='content' value='adm_usergroups' />
      <input type='hidden' name='task' value='edit_item' />
      <input type='hidden' name='xid' value='' />
      <input type='hidden' name='id' value='' />

   </fieldset>

   </form>

</div>
