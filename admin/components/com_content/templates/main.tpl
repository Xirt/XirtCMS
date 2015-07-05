<form action="index.php" method="post" class="xForm" id="xForm">

<h1>{$xLang->titles["component"]}</h1>

<div class="column">

	<h3>{$xLang->headers["editSettings"]}</h3>

	<fieldset class="box-form">

		<hr />

		<label for="item_css_name">{$xLang->labels["CSSName"]}</label>
		<input type="text" name=item_css_name value="{$configuration->css_name}" maxlength="64" class="validate-simple" />

		<br />

		<label>{$xLang->labels["showTitle"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_show_title_1" name="item_show_title" value="1" class="radio" {if $configuration->show_title}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_title_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_show_title_2" name="item_show_title" value="0" class="radio" {if !$configuration->show_title}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_title_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label>{$xLang->labels["showAuthor"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_show_author_1" name="item_show_author" value="1" class="radio" {if $configuration->show_author}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_author_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_show_author_2" name="item_show_author" value="0" class="radio" {if !$configuration->show_author}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_author_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label>{$xLang->labels["showCreated"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_show_created_1" name="item_show_created" value="1" class="radio" {if $configuration->show_created}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_created_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_show_created_2" name="item_show_created" value="0" class="radio" {if !$configuration->show_created}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_created_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label>{$xLang->labels["showModified"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_show_modified_1" name="item_show_modified" value="1" class="radio" {if $configuration->show_modified}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_modified_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_show_modified_2" name="item_show_modified" value="0" class="radio" {if !$configuration->show_modified}checked="checked"{/if}/>
			<label class='buttonset' for='item_show_modified_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label>{$xLang->labels["backIcon"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_back_icon_1" name="item_back_icon" value="1" class="radio" {if $configuration->download_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_back_icon_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_back_icon_2" name="item_back_icon" value="0" class="radio" {if !$configuration->download_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_back_icon_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label>{$xLang->labels["downloadIcon"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_download_icon_1" name="item_download_icon" value="1" class="radio" {if $configuration->download_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_download_icon_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_download_icon_2" name="item_download_icon" value="0" class="radio" {if !$configuration->download_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_download_icon_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label for="item_print_icon">{$xLang->labels["printIcon"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_print_icon_1" name="item_print_icon" value="1" class="radio" {if $configuration->print_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_print_icon_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_print_icon_2" name="item_print_icon" value="0" class="radio" {if !$configuration->print_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_print_icon_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<label for="item_mail_icon">{$xLang->labels["mailIcon"]}</label>
		<div class="dvButtons">

			<input type="radio" id="item_mail_icon_1" name="item_mail_icon" value="1" class="radio" {if $configuration->mail_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_mail_icon_1'>{$xLang->options["showItem"]}</label>
			<input type="radio" id="item_mail_icon_2" name="item_mail_icon" value="0" class="radio" {if !$configuration->mail_icon}checked="checked"{/if}/>
			<label class='buttonset' for='item_mail_icon_2'>{$xLang->options["hideItem"]}</label>

		</div>

		<hr />

		<div class="box-buttons">

			<input type="hidden" name="content" value="com_content" />
			<input type="hidden" name="task" value="save" />

			<button type="submit" class="save left green">{$xLang->buttons["save"]}</button>
			<button type="button" class="reset right red" id="xReset">{$xLang->buttons["reset"]}</button>

		</div>

	</fieldset>

</div>

<div class="column preview">

	<h3>{$xLang->headers["preview"]}</h3>

	<fieldset class="box-form preview">

		<div class="box-preview">

			<h5 id="show_title">XXXXX XXX XX XX</h5>
			<span id="show_author"><b>XXXXXXX:</b> XXX XXXXXX<br /></span>
			<span id="show_created"><b>XXXXXXX:</b> XX/XX/XXXX<br /></span>

			x xx x xx xx xx x x x x xx xx xxxxx xxx x xxxx xx xxx xxx xxxx x xx
			xxxxxxxx xxxx xxxx xxxx x x xxxx xxxxxxxxxx x x xx x x xxx x xxxxxx
			xx xxxxx xxx xx xxxxxxx xxxx xx xxxxxxxx x x xxx xxxx xxxx x xxx x
			xx xxxxx xxxxx x xxx xxxxxxxx x xxxx x xxx xxxxxx xxxx x xxx xxxxxx
			xx x x xx xx x x x xxxxxxxxxx xxxxxxx xx xxxxx x x xxxx xxxx xxxxxx
			x x xx x xx xxxxxxxxxxxxxxx x xxxxxxx x xxxxxxx xx x xxxx xx xx x x
			xxxxx xxxxxx xxxxxx xxxxxxx xxxxxxxxx x xxx xxxx xxxxxx x xxxxx x
			xxx xx xxxxx xx xx xxxxxxxx x x xx xx xxxx xxxx xxxxx xx xxxxxxxxx
			x x xx xx xxxxx x x xxxx xx x x xxxxxxxx x xx x xxxx xx x xxxx xxx
			xxxx xxx xxxxxxxxxxxx xxxxx x xxxxxxx xxxx x x xx xxx x xxxxxxxxxxx
			x xxxxxxxx xxxx xxxxxx xxxxx x xxxxxxx xx x xxx x x x xxxx x xxxx x
			xxxxxxxxx x xx xxxxx xxx xxxxxx x xx xxxxxxxxxxxx xxxxx x x x xx xx
			xxxxxx xx x xxx x xxx xxx xx xx xxxxxxx xxx xxxx xx xx x x xxxx x
			xx xxxxxxx xxxx x x xxxx xx xxxxx xxxx xx x x x xx xxx xxx xxxxxx
			xxxx xxx xx x xxx x x x x xxx x xxxxxxxx xxxx xx xx x xx xxxxxxx
			xxxxxxxxx x xx xx x xxxxxxx x xxxxx xxx xx x xxxxx xxxx xxxx x xxxx
			xxxxxx x x x xx x xxxx x xxxx xxxxxx x x xx x xxx xxx xxxx xxxxxx
			xxxxxxxxxxx xx x x x xxxx x xxx x x x x xx x xxx xxx x x x x xx xx

			<div id="show_modified"><i>XXXX XXXXX XX XXXX XXXXXXXX XXX XX</i></div>

			<div class="box-icons">

				 <div class="icon" id="back_icon"></div>

				 <div class="icon" id="download_icon"></div>

				 <div class="icon" id="print_icon"></div>

				 <div class="icon" id="mail_icon"></div>

			</div>

		</div>

	</fieldset>

</div>

</form>