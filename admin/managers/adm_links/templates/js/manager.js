$(function() {

	new AddPanel();
	xConf.component = "adm_links";
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
				name: "id",
				label: XComLang.columns["id"],
				sortable: true,
				contents: this._id
			},
			{
				name: "alternative",
				label: XComLang.columns["link"],
				sortable: true
			},
			{
				name: "query",
				label: XComLang.columns["query"],
				sortable: true
			},
			{
				name: "cid",
				label: XComLang.columns["cid"],
				sortable: true
			},
			{
				name: "options",
				label: XComLang.columns["options"],
				sortable: false,
				contents: this._options
			}

		]});

	},

	this._id = function(cell, item) {
		cell.text(Xirt.pad(item.id, 5));
	},

	this._options = function(cell, item, widget) {

		if (parseInt(item.translation)) {

			$("<img src='../images/cms/icons/new.png'>")
			.click({xid : item.rank}, XAdmin.translate)
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
			title	: XComLang.headers["addLink"],

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

		$("#dvItem").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["editLink"],

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