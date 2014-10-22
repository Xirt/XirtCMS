$(function() {

	new AddPanel();
	xConf.component = "adm_menus";
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
				label: XComLang.columns["id"],
				sortable: false,
				contents: this._id
			},
			{
				name: "title",
				label: XComLang.columns["title"],
				sortable: false
			},
			{
				name: "ordering",
				label: XComLang.columns["ordering"],
				sortable: false,
				contents: this._ordering
			},
			{
				name: "sitemap",
				label: XComLang.columns["sitemap"],
				sortable: false,
				contents: this._sitemap
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
		cell.text(Xirt.pad(item.xid));
	},

	this._ordering = function(cell, item) {

		$("<button type='button'></button>")
		.attr("title", XComLang.tips["moveDown"])
		.click({xid : item.xid}, XAdmin.moveDown)
		.addClass("move-down tooltip")
		.appendTo(cell);

		$("<button type='button'></button>")
		.attr("title", XComLang.tips["moveUp"])
		.click({xid : item.xid}, XAdmin.moveUp)
		.addClass("move-up tooltip")
		.appendTo(cell);

	};

	this._sitemap = function(cell, item) {

		$("<img src='../images/cms/icons/published_" + item.sitemap + ".png'>")
		.attr("title", XComLang.tips["sitemap"])
		.click({id : item.id}, XAdmin.toggleSitemap)
		.addClass("url tooltip")
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

		$("<img src='../images/cms/icons/menu.png'>")
		.attr("title", XComLang.tips["menu"])
		.click({xid : item.xid}, XAdmin.viewMenu)
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

$.extend(XAdmin, {

	viewMenu : function(event) {

		link = "index.php?content=adm_menueditor&menu_id=";
		document.location.href = link + event.data.xid;

	}

});


/****************************
* Class to show 'add'-panel *
****************************/
function AddPanel() {

	this.init = function() {

		var widget = $("#dvAdd").panel({

			type	: "add",
			title	: XComLang.headers["addMenu"],

			onPopulate: function(form, data) {
				form.find("[name=nx_language]").val(xConf.language);
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


/*******************************
* Class to show 'edit'-panel *
*******************************/
function EditPanel(event) {

	this.init = function(event) {

		$("#dvItem").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["editMenu"],

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this.init(event);

}