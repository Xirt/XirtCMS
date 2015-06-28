$(function() {

	new AddPanel();
	xConf.component = "adm_modules";
	xConf.itemList = new ContentPanel().getList();

});


function ContentPanel() {

	this.getList = function() {
		return this.list;
	},

	this._init = function() {

		this.list = $("#list");
		this.list.xlist({

			translations: true,
			columns: [
			{
				name: "xid",
				label: XComLang.labels["id"],
				sortable: true,
				contents: this._id
			},
			{
				name: "name",
				label: XComLang.labels["name"],
				sortable: true
			},
			{
				name: "type",
				label: XComLang.labels["type"],
				sortable: true
			},
			{
				name: "position",
				label: XComLang.labels["position"],
				sortable: true
			},
			{
				name: "published",
				label: XComLang.labels["status"],
				sortable: true,
				contents: this._status
			},
			{
				name: "options",
				label: XComLang.labels["options"],
				sortable: false,
				contents: this._options
			}

		]});

	},

	this._id = function(cell, item) {
		cell.text(Xirt.pad(item.xid));
	};

	this._status = function(cell, item) {

		$("<img src='../images/cms/icons/published_" + item.published + ".png'>")
		.attr("title", XComLang.tips["status"])
		.click({id : item.id}, XAdmin.toggleStatus)
		.addClass("url tooltip")
		.appendTo(cell);

	};

	this._mobile = function(cell, item) {

		opacity = Math.min(item.mobile + 0.5, 1);
		$("<img src='../images/cms/icons/visible.png'>")
		.attr("title", XComLang.tips["mobile"])
		.click({id : item.id}, XAdmin.toggleMobile)
		.addClass("url tooltip")
		.fadeTo(0, opacity)
		.appendTo(cell);

	};

	this._options = function(cell, item, widget) {

		if (parseInt(item.translation)) {

			$("<img src='../images/cms/icons/new.png'>")
			.click({xid : item.xid}, XAdmin.translate)
			.attr("title", XComLang.tips['translate'])
			.addClass("url tooltip")
			.appendTo(cell);

			return false;
		}

		$("<img src='../images/cms/icons/edit.png'>")
		.attr("title", XComLang.tips["edit"])
		.click({id : item.id}, EditPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		$("<img src='../images/cms/icons/config.png'>")
		.attr("title", XComLang.tips["config"])
		.click({id : item.id}, ConfigPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		$("<img src='../images/cms/icons/access.png'>")
		.attr("title", XComLang.tips["access"])
		.click({id : item.id}, AccessPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		$("<img src='../images/cms/icons/remove.png'>")
		.attr("title", XComLang.tips["remove"])
		.click({id : item.id}, XAdmin.remove)
		.addClass("url tooltip")
		.appendTo(cell);

	};

	return this._init();

}


/****************************
* Class to show 'add'-panel *
****************************/
function AddPanel() {

	this.init = function() {

		var widget = $("#dvAdd").panel({

			type	: "add",
			title	: XComLang.headers["addModule"],

			onPopulate: function(form, data) {
				form.find("[name=nx_language]").val(xConf.language);
			},

			onSubmit: function(out) {

				if (out && out.length) {
					return $.jGrowl(out);
				}

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

		$("#button-add").click(function(event) {

			widget.panel("open");
			event.preventDefault();

		});

	};

	this.init();

}



/*******************************
* Class to show 'edit'-panel *
*******************************/
function EditPanel(event) {

	this.init = function(event) {

		var widget = this;

		$("#dvItem").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			task		: "show_details",
			title		: XComLang.headers["editModule"],

			onPopulate: function(form, data) {

				var container = $("#configuration").empty();

				$.each(data.config, function(index, info) {

					switch (info.type) {

						case "text":
							widget._addTextField(info, container);
							break;

						case "toggle":
							widget._addToggleField(info, container);
							break;

						case "select":
							widget._addSelectField(info, container);
							break;

					}

				});

				form.find("[name=affect_all]").attr("checked", false);

			},

			onSubmit: function(out) {

				if (out && out.length) {
					return $.jGrowl(out);
				}

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this._addTextField = function(data, container) {

		$("<label></label>")
		.attr("for", "xvar_" + data.name)
		.text(data.label)
		.appendTo(container);

		$("<input type='text' />")
		.attr("id", "xvar_" + data.name)
		.attr("name", "xvar_" + data.name)
		.text(data.label)
		.val(data.value)
		.appendTo(container);

	};

	this._addToggleField = function(data, container) {

		$("<label></label>")
		.text(data.label)
		.appendTo(container);

		var buttonset = $("<div></div>")
		.appendTo(container);

		$.each(data.options, function(index, value) {

			var id = 1 + Math.floor(Math.random() * 6);

			$("<input type='radio' />")
			.attr("checked", value == data.value)
			.attr("id", "xvar_" + data.name + id)
			.attr("name", "xvar_" + data.name)
			.appendTo(buttonset)
			.val(value);

			$("<label class='buttonset'></label>")
			.attr("for", "xvar_" + data.name + id)
			.appendTo(buttonset)
			.text(index);

		});

		buttonset.buttonset();

	};

	this._addSelectField = function(data, container) {

		$("<label></label>")
		.attr("for", "xvar_" + data.name)
		.text(data.label)
		.appendTo(container);

		var el = $("<select></select>")
		.attr("id", "xvar_" + data.name)
		.attr("name", "xvar_" + data.name)
		.appendTo(container);

		$.each(data.options, function(index, value) {

			$("<option></option")
			.text(index)
			.val(value)
			.appendTo(el);

		});

		el.val(data.value);
	};

	this.init(event);

}


/*******************************
* Class to show 'config'-panel *
*******************************/
function ConfigPanel(event) {

	this.init = function(event) {

		$("#pageSelector").mousedown(function(event) {
			event.metaKey = true;
		}).selectable();

		$("#dvConfig").panel({

			width		: 525,
			autoOpen	: true,
			type		: "edit",
			maxHeight	: "auto",
			id			: event.data.id,
			title		: XComLang.headers["editConfig"],

			onPopulate: function(form, data) {

				data = data.pages.split('|');

				$.each($(form).find("li"), function(index, el) {

					el = $(el);
					el.removeClass("ui-selected");

					$.each(data, function(index, value) {

						if (el.attr("data-page") == value) {
							el.addClass("ui-selected");
						}

					});

				});

			},

			onValidate: function(form, data) {

				form = $(form);
				var pages = form.find(".ui-selected").map(function() {
					var value = $(this).attr("data-page");
					return (isNaN(value) || value > -1) ? value : null;
				});

				form.find("[name=x_pages]").val('|' + pages.get().join('|') + '|');

			},

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this.init(event);

}


/*******************************
* Class to show 'access'-panel *
*******************************/
function AccessPanel(event) {

	this.init = function(event) {

		$("#dvAccess").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["editAccess"],

			onPopulate: function(form, data) {
				form.find("[name=affect_all]").attr("checked", true);
			},

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this.init(event);

}