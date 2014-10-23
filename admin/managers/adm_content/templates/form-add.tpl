<div id='dvAdd' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

		<fieldset class='box-form'>

			<label for='nx_title'>{$xLang->labels['title']}</label>
			<input type='text' id='nx_title' name='nx_title' value='' maxlength='128' class='required' />

			<br />

			<label for='nx_category'>{$xLang->labels['category']}</label>
			<select id='nx_category' name='nx_category'>
				<optgroup label='{$xLang->misc['optDefault']}'>
					<option value='0'>{$xLang->misc['noCategory']}</option>
				</optgroup>
				<optgroup label='{$xLang->misc['optCategories']}' id='nx_category'></optgroup>
			</select>

			<br />
			<label for='nx_language'>{$xLang->labels['language']}</label>
			{html_options options=$languages id=nx_language name=nx_language}

			<input type='hidden' name='content' value='adm_content' />
			<input type='hidden' name='task' value='add_content' />

		</fieldset>

	</form>

</div>
