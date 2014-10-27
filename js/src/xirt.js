$.jGrowl.defaults.closer = false;
$.jGrowl.defaults.position = "top-right";

var Form = Form ? Form : [];
var xConf = xConf ? xConf : {};

$(function() {

	Xirt.activate();
	$("#xStatsBox").click(function(){
		$(this).fadeOut();
	});

});

/*********************************************************
*          XIRT - Utility Library for XirtCMS            *
*              (version 2.0 - 12.01.2014)                *
**********************************************************/
var Xirt = {

	activate : function() {

		// External links
		$.each($("a[rel*=external]"), function(index, el) {

			$(el).attr("target", "_blank");
			$(el).addClass("external");

		});

	},

	noAJAX : function() {
		Xirt.error(XLang.errors["communication"]);
	},

	error : function(text) {
		$.jGrowl(text, { themeState : "error" });
	},

	notice : function(text) {
		$.jGrowl(text);
	},

	populateForm : function(form, data) {

		$.each(data, function(key, value) {

			if ((element = form.find("[name=x_" + key + "]")) && element.length) {
				return element.val(value);
			}

			if ((element = form.find("[name=" + key + "]")) && element.length) {
				return element.val(value);
			}

			return true;

		});

	},

	pad: function(str, length, chr) {

		chr = chr ? chr : '0';
		length = length ? length : 5;

		return str.length < length ? this.pad(chr + str, length, chr) : str;
	},

	lead: function(str, length) {
		return this.pad(str, length + str.length, "\u00a0");
	}

};


/*********************************************************
*      CONFIRMATION - Standard XirtCMS Confirmation      *
*              (version 1.0 - 13.01.2014)                *
**********************************************************/
var confirmation = function(options) {

	this.options = {
		height: 85,
		modal: true,
		show: "fade",
		hide: "fade",
		width: "auto",
		autoOpen: true,
		resizable: false,
		dialogClass: "no-close no-header",
		message : XLang.confirmations["default"],
		onConfirm : function() { },
		onCancel : function() { }
	},

	this._create = function(options) {

		$.extend(true, this.options, options);

		this.element = $("<div></div>")
		.text(this.options.message)
		.dialog(this.options);

		this._buttons();

	};

	this._buttons = function() {

		var widget = this;

		this.element.dialog("option", {

			buttons: [{
				text : XLang.misc["yes"],
				click: function () {
					widget.options.onConfirm();
					$(this).dialog("close");
				},
			}, {
				text : XLang.misc["no"],
				click: function() {
					widget.options.onCancel();
					$(this).dialog("close");
				}
			}]

		});

	};

	this._create(options);

};


/*********************************************************
*         FORM.VALIDATE - Default Form Validation        *
*                (version 1.0 - 13.01.2014)              *
**********************************************************/
Form.Validate = function(form, options) {

	options = $.extend({
		onSuccess : function() {}
	}, options);

	form.validate({

		submitHandler: options.onSuccess,

		errorPlacement: function (error, element) {

			// Prevents issue #37
			$(element).attr("title", "");

			$(element).tooltip("option", "content", error.text());
			$(element).tooltip("open");

		},

		success: function (label, element) {
			$(element).tooltip("close");
		}

	});

	form.find(":input").each(function() {

		$(this).tooltip({

			hide : "fade",
			show : "fade",
			disabled: true,
			position: {
				my: "left+5 center",
				at: "right center"
			}

		}).off("mouseover focusin");

	});

};


/*********************************************************
*        FORM.REQUEST - Default Form Submit (AJAX)       *
*                (version 1.0 - 13.01.2014)              *
**********************************************************/
Form.Request = function(form, options) {

	options = $.extend({
		onSuccess: function() {},
		onFailure: Xirt.noAJAX,
		onSend: function() {},
		target: form.target,
		method: "POST"
	}, options);

	jQuery.ajax({
		url: options.target,
		method: options.method,
		data: $(form).serialize(),
		beforeSend: options.beforeSend
	}).done(options.onSuccess)
	.fail(options.onFailure);

};


/*********************************************************
*        Reset - Extends JQuery to reset elements        *
*                (version 1.0 - 19.01.2014)              *
**********************************************************/
jQuery.fn.reset = function (fn) {
	return fn ? this.bind("reset", fn) : this.trigger("reset");
};


/*********************************************************
*   Validator - Extends JQuery to check string format    *
*                (version 1.0 - 29.01.2014)              *
**********************************************************/
$.validator.addMethod("alphabetical", function(value, element) {
	return this.optional(element) || /^[a-z]+$/i.test(value);
});


$.validator.addMethod("alphanumeric", function(value, element) {
	return this.optional(element) || /^[a-z0-9]+$/i.test(value);
});


$.validator.addMethod("simple", function(value, element) {
	return this.optional(element) || /^[a-z0-9._-]+$/i.test(value);
});


$.validator.addMethod("integer", function(value, element) {
	return this.optional(element) || /^-?\d+$/.test(value);
});


$.validator.addMethod("phone", function(value, element) {
	return this.optional(element) || /^[0-9\s\(\)\+\-]+$/i.test(value);
});


$.validator.addMethod("password", function(value) {
	return /^[A-Za-z0-9!@#$%^&*()_-]*$/.test(value)
	&& /[A-Z]/.test(value)
	&& /[a-z]/.test(value)
	&& /\d/.test(value);
});