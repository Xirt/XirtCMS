$(function() {

	$("#xPrint").attr("target", "_blank");
	$("#xBack").click(function(e) {

		e.preventDefault();
		history.go(-1); 

	});

	if ($("#xMail")) {
		new ForwardPanel();
	}

});


/********************************
* Class to show 'forward'-panel *
********************************/
function ForwardPanel() {

	this._init = function() {

		var widget = $("#xForward").panel({

			autoOpen	: true,
			type		: "add",
			title		: "Tell A Friend",

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				this.close();

			}

		});

		$("#xMail").click(function(event) {
	
			widget.panel("open");
			event.preventDefault();
	
		});

	};

	this._init();

}