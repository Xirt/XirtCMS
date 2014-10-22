<div id='dvPassword' style='display: none;'>

	<form action='index.php' method='post' class='xForm'>

	<div id='pwform'>

		<fieldset class='box-form'>

			<label for='x_password'>{$xLang->labels['password']}</label>
			<input type='password' id='x_password' name='x_password' value='' minLength="8" />

			<br />

			<label for='x_password_rt'>{$xLang->labels['password']}</label>
			<input type='password' id='x_password_rt'  name='x_password_rt' value='' class="required" equalTo="#x_password" />

		</fieldset>

	</div>

	<fieldset class='box-form'>

		<input type='checkbox' name='pwtoggle' id='pwtoggle' value='0' class='checkbox' />
		{$xLang->misc['randomizePassword']}

		<input type='hidden' name='content' value='adm_users' />
		<input type='hidden' name='task' value='reset_password' />
		<input type='hidden' name='id' value='' />

	</fieldset>

	</form>

</div>
