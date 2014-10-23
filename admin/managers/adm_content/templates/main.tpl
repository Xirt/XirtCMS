<h1>{$xLang->titles['component']}</h1>

<div class='listBox'>

   <div class='box-tools'>
      <a href='javascript:;' id='button-add' class='new'>{$xLang->headers['addItem']}</a>
   </div>

   <div id='list' class='xlist'></div>

</div>

<div class='box-legend'>

   <div class='legend'>

      <div class='box-translation'></div>
      {$xMainLang->legends['translation']}

   </div>

   <div class='legend'>

      <div class='box-missing'></div>
      {$xMainLang->legends['noTranslation']}

   </div>

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}

{include file="form-access.tpl"}