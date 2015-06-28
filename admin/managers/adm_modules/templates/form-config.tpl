<div id="dvConfig" style="display: none;">

   <form action="index.php" method="post" class="xForm">

   <fieldset class="box-form">

      <label for="x_position">{$xLang->labels["position"]}</label>
      {html_options options=$positions id=x_position name=x_position}

      <br />

      <label for="x_ordering">{$xLang->labels["ordering"]}</label>
      {html_options options=$xLang->options["ordering"] id=x_ordering name=x_ordering}

      <br />

      <label>{$xLang->labels["pages"]}</label>
      <ol id="pageSelector">
      {foreach from=$pages item=page key=value}
         <li data-page="{$value}">{$page}</li>
      {/foreach}
      </ol>

      <div class="box-affect">

         {$xLang->misc["affectAll"]}

      </div>

      <input type="hidden" name="content" value="adm_modules" />
      <input type="hidden" name="task" value="edit_config" />
      <input type="hidden" name="x_pages" value="" />
      <input type="hidden" name="xid" value="" />

   </fieldset>

   </form>

</div>
