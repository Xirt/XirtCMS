$(function() {

	// Activate buttons
	$("#xReset").click(_reset);
	$(".dvButtons").buttonset();
	$("input[type=radio]").change(_toggle).trigger("change");

	// Activate form
	var form = $("#xForm");
	Form.Validate(form, {

		onSuccess: function(form) {

			new Form.Request(form, {
				onSuccess: function() {
					Xirt.notice(XLang.messages["saved"]);
				}
			});

		}

	});

	function _toggle() {

		var name = this.name;
		var target = $("#" + name.substr(5));
		var targetValue = $("input[name=" + this.name + "]:checked").val();
		(targetValue < 1) ? target.hide() : target.show();

	}

	function _reset() {

		form.reset();
		$.each($("input[type='radio']"), function(index, el) {
			$(el).trigger("change");
		});

	}

});