<div id="dvAdd" style="display: none;">

   <form action="index.php" method="post" class="xForm">

   <fieldset class="box-form">

      <label for="nx_term">{$xLang->labels["term"]}</label>
      <input type="text" id="nx_term" name="nx_term" value="" class="required" />

      <br />

      <label for="nx_uri">{$xLang->labels["uri"]}</label>
      <input type="text" id="nx_uri" name="nx_uri" value="" class="required" />

      <br />

      <label for="nx_impressions">{$xLang->labels["impressions"]}</label>
      <input type="text" id="nx_impressions" name="nx_impressions" value="" class="required digits" />

      <br />

      <label for="nx_language">{$xLang->labels["ISO"]}</label>
      {html_options options=$languages id=nx_language name=nx_language}

      <input type="hidden" name="content" value="com_search" />
      <input type="hidden" name="task" value="add_item" />

   </fieldset>

   </form>

</div>
