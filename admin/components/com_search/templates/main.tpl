<h1>{$xLang->titles["component"]}</h1>

<div class="box-list">

	<div class="box-tools">

		<a href="javascript:;" id="button-config" class="settings">{$xLang->headers["engineSettings"]}</a>
		<a href="javascript:;" id="button-add" class="new">{$xLang->headers["addItem"]}</a>

	</div>

	<div id="list" class="xlist"></div>

</div>

{include file="form-add.tpl"}

{include file="form-edit.tpl"}

{include file="form-config.tpl"}