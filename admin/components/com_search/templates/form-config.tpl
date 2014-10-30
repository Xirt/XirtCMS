<div id="dvConfig" style="display: none;">

	<form action="index.php" method="post" class="xForm">

	<fieldset class="box-form">

		<label for="toggleMethod">{$xLang->labels["searchType"]}</label>
		{html_options name=x_search_type options=$xLang->options["search"] selected=$configuration->search_type id="toggleMethod"}

		<br />

		<label>{$xLang->labels["recordTerms"]}</label>

		<div id="dvRecording">

			<input type="radio" id="x_recording_1" name="x_recording" value="1" class="radio" {if $configuration->recording}checked="checked"{/if}/>
			<label class='buttonset' for='x_recording_1'>{$xLang->options["positive"]}</label>
			<input type="radio" id="x_recording_2" name="x_recording" value="0" class="radio" {if !$configuration->recording}checked="checked"{/if}/>
			<label class='buttonset' for='x_recording_2'>{$xLang->options["negative"]}</label>

		</div>

		<label for="x_default_value">{$xLang->labels["defaultValue"]}</label>
		<input type="text" id="x_default_value" name="x_default_value" value="{$configuration->default_value}" />

		<br />

		<label for="x_default_limit">{$xLang->labels["defaultLimit"]}</label>
		<input type="text" id="x_default_limit" name="x_default_limit" value="{$configuration->default_limit}" class="required validate-digits" />

		<br />

		<label>{$xLang->labels["defaultMethod"]}</label>
		<div class="method" id="method_0">{html_options name=x_default_method_0 options=$xLang->options["normal"] selected=$configuration->default_method}</div>
		<div class="method" id="method_1">{html_options name=x_default_method_1 options=$xLang->options["fulltext"] selected=$configuration->default_method}</div>

		<label for="x_titlelength">{$xLang->labels["titleLength"]}</label>
		<input type="text" id="x_titlelength" name="x_titlelength" value="{$configuration->titlelength}" class="required validate-digits" />

		<br />

		<label for="x_textlength">{$xLang->labels["textLength"]}</label>
		<input type="text" id="x_textlength" name="x_textlength" value="{$configuration->textlength}" class="required validate-digits" />

		<br />

		<label for="x_node_id">{$xLang->labels["nodeId"]}</label>
		<input type="text" id="x_node_id" name="x_node_id" value="{$configuration->node_id}" class="required validate-digits" />

		<input type="hidden" name="content" value="com_search" />
		<input type="hidden" name="task" value="edit_config" />

	</fieldset>

	</form>

</div>
