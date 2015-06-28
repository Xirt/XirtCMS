<div id="dvAccess" style="display: none;">

   <form action="index.php" method="post" class="xForm">

   <fieldset class="box-form">

      <label for="access_min">{$xLang->labels["accessMin"]}</label>
      {html_options id=access_min name=access_min options=$ranks}

      <br />

      <label for="access_max">{$xLang->labels["accessMax"]}</label>
      {html_options id=access_max name=access_max options=$ranks}

      <br />

      <div class="box-affect">

         <input type="checkbox" name="affect_all" value="1" class="checkbox" />
         {$xLang->options["affectAll"]}

      </div>

      <input type="hidden" name="content" value="adm_modules" />
      <input type="hidden" name="task" value="edit_access" />
      <input type="hidden" name="xid" value="" />
      <input type="hidden" name="id" value="" />

   </fieldset>

   </form>

</div>
