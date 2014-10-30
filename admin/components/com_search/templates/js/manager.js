$(function() {

	new AddPanel();
	new ConfigPanel();
	xConf.component = "com_search";
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
			column: "count",
			order: "DESC",
			columns: [
			{
				name: "id",
				label: "ID #",
				sortable: true,
				contents: this._id
			},
			{
				name: "term",
				label: "Term",
				sortable: true
			},
			{
				name: "uri",
				label: "URL (target)",
				sortable: true
			},
			{
				name: "impressions",
				label: "Count",
				sortable: true
			},
			{
				name: "options",
				label: "&nbsp;",
				sortable: false,
				contents: this._options
			}

		]});

	},

	this._id = function(cell, item) {
		cell.text(Xirt.pad(item.id));
	};

	this._options = function(cell, item, widget) {

		$("<img src='../images/cms/icons/edit.png'>")
		.attr("title", XComLang.tips["edit"])
		.click({id : item.id}, EditPanel)
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

			title : XComLang.headers["addTerm"],
			type: 'add',

			onPopulate: function(form, data) {
				form.find('[name=nx_language]').val(xConf.language);
			},

			onSubmit: function() {

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


/*****************************
* Class to show 'edit'-panel *
*****************************/
function EditPanel(event) {

	this.init = function(event) {

		$("#dvItem").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["editTerm"],

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

	this.init(event);

}


/*******************************
* Class to show 'config'-panel *
*******************************/
function ConfigPanel() {

	this.init = function() {

		$("#dvRecording").buttonset();
		var widget = $("#dvConfig").panel({

			type : "add",
			title : XComLang.headers["editConfig"]

		});

		$("#toggleMethod").change(function() {

			var method = $(this).val();
			$.each($("div.method"), function(index, el) {
				(index == method) ? $(el).show() : $(el).hide();
			});

		}).trigger("change");

		$("#button-config").click(function(event) {

			widget.panel("open");
			event.preventDefault();

		});

	},

	this.init();

}