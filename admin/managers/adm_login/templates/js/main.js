$(function() {

	new ResetPanel();
	new LoginPanel();

});


/******************************
* Class to show 'login'-panel *
******************************/
function LoginPanel() {

	this.init = function(form) {

		$("#form-login").submit(function(event) {

			new Form.Request(this, {

				onSuccess: function(output) {

					if (output && output.length) {
						return Xirt.notice(output);
					}

					location.reload(true);
				}

			});

			event.preventDefault();

		});

	};

	this.init();
};


/******************************
* Class to show 'reset'-panel *
******************************/
function ResetPanel() {

	this.init = function() {

		var container = $("#dvRequestPassword").panel({

			type: "add",
			onSubmit: function(out) {

				$.jGrowl(out);
				this.close();

			}

		});

		$("#a-password").click(function(event) {

			container.panel("open");
			event.preventDefault();

		});

	};

	this.init();

};