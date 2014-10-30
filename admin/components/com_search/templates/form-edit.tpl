<div id="dvItem" style="display: none;">

   <form action="index.php" method="post" class="xForm">

   <fieldset class="box-form">

      <label for="x_term">{$xLang->labels["term"]}</label>
      <input type="text" id="x_term" name="x_term" value="" class="required" />

      <br />

      <label for="x_uri">{$xLang->labels["uri"]}</label>
      <input type="text" id="x_uri" name="x_uri" value="" class="required" />

      <br />

      <label for="x_impressions">{$xLang->labels["impressions"]}</label>
      <input type="text" id="x_impressions" name="x_impressions" value="" class="required digits" />

      <input type="hidden" name="content" value="com_search" />
      <input type="hidden" name="task" value="edit_item" />
      <input type="hidden" name="iso" value="" />
      <input type="hidden" name="id" value="" />

   </fieldset>

   </form>

</div>
