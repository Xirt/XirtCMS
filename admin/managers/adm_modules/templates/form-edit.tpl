<div id="dvItem" style="display: none;">

   <form action="index.php" method="post" class="xForm">

   <fieldset class="box-form">

      <label for="x_name">{$xLang->labels["name"]}</label>
      <input type="text" id="x_name" name="x_name" maxlength="128" class="required" />

      <hr />

      <div id="configuration"></div>

      <div class="box-affect">

         <input type="checkbox" name="affect_all" value="1" class="checkbox" />
         {$xLang->options["affectAll"]}

      </div>

      <input type="hidden" name="content" value="adm_modules" />
      <input type="hidden" name="task" value="edit_item" />
      <input type="hidden" name="xid" value="" />
      <input type="hidden" name="id" value="" />

   </fieldset>

   </form>

</div>
