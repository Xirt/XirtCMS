$(function() {

	xConf.component = "com_twitter";
	xConf.itemList = new ContentPanel().getList();

});


function ContentPanel() {

	this.getList = function() {
		return this.list;
	},

	this._init = function() {

		this.list = $("#list");
		this.list.xlist({

			columns: [
			{
				name: "author",
				label: XComLang.labels["author"],
				sortable: true
			},
			{
				name: "content",
				label: XComLang.labels["content"],
				sortable: true
			},
			{
				name: "created",
				label: XComLang.labels["created"],
				sortable: true
			},
			{
				name: "published",
				label: XComLang.labels["published"],
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

	this._status = function(cell, item) {

		$("<img src='../images/cms/icons/published_" + item.published + ".png'>")
		.attr("title", XComLang.tips["status"])
		.click({id : item.id}, XAdmin.toggleStatus)
		.addClass("url tooltip")
		.appendTo(cell);

	};

	this._options = function(cell, item, widget) {

		$("<img src='../images/cms/icons/remove.png'>")
		.attr("title", XComLang.tips["remove"])
		.click({id : item.id}, XAdmin.remove)
		.addClass("url tooltip")
		.appendTo(cell);

	};

	return this._init();

}