<h1>{$xLang->titles['component']}</h1>

<div class='box-xlist'>

	{if $errors->count}
	<div class='box-tools'>
		<a href='javascript:;' id="button-log" class='new'>{$xLang->headers['viewLog']} ({$errors->count})</a>
	</div>
	{/if}

	<div id='list' class='xlist'></div>

</div>

{include file="form-entry.tpl"}