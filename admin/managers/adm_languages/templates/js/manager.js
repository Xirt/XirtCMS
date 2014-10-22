$(function() {

	xConf.component = "adm_languages";
	xConf.itemList = new ContentPanel().getList();

});


function ContentPanel() {

	this.getList = function() {
		return this.list;
	},

	this._init = function() {

		this.list = $("#list");
		this.list.xlist({

			filter: false,
			columns: [
			{
				name: "flag",
				label: XComLang.columns["flag"],
				sortable: false,
				contents: this._flag
			},
			{
				name: "iso",
				label: XComLang.columns["iso"],
				sortable: false
			},
			{
				name: "name",
				label: XComLang.columns["name"],
				sortable: false
			},
			{
				name: "ordering",
				label: XComLang.columns["ordering"],
				sortable: false,
				contents: this._ordering
			},
			{
				name: "published",
				label: XComLang.columns["published"],
				sortable: false,
				contents: this._status
			}

		]});

	},

	this._flag = function(cell, item) {

		$("<img src='../images/cms/flags/" + item.iso + ".png'>")
		.addClass("tooltip")
		.appendTo(cell);

	},

	this._ordering = function(cell, item) {

		$("<button type='button'></button>")
		.attr("title", XComLang.tips["moveDown"])
		.click({id : item.id}, XAdmin.moveDown)
		.addClass("move-down tooltip")
		.appendTo(cell);

		$("<button type='button'></button>")
		.attr("title", XComLang.tips["moveUp"])
		.click({id : item.id}, XAdmin.moveUp)
		.addClass("move-up tooltip")
		.appendTo(cell);

	};

	this._status = function(cell, item) {

		$("<img src='../images/cms/icons/published_" + item.published + ".png'>")
		.attr("title", XComLang.tips["status"])
		.click({id : item.id}, XAdmin.toggleStatus)
		.addClass("url tooltip")
		.appendTo(cell);

	};

	return this._init();

}