$.widget("mod.contact", {

	_init: function() {

		var form = $(this.element);
		var buttonBox = form.children(".box-buttons");
		var contactBox = form.children(".box-contact");

		Form.Validate(form, {

			onSuccess: function(form) {

				buttonBox.fadeOut();
				$.each(buttonBox.children("button"), function(el) {
					$(el).attr("disabled", "disabled");
				});

				new Form.Request(form, {

					onSend: function() {
						contactBox.html(XLang.messages["process"]);
					},

					onSuccess: function(out) {
						contactBox.html(out);
					}

				});


			}

		});

	}

});


$(function() {
	$(".x-mod-contact-form").contact();
});