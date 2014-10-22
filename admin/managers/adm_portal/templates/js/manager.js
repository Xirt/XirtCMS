$(function() {

	xConf.component = "adm_portal";
	xConf.itemList = new ContentPanel().getList();

	$("#button-log").click(function(event) {

		var widget = $("<div>test</div>");
		widget.panel({

			autoOpen	: true,
			dialogClass : "log",
			type		: "view",
			width		: 'auto',
			height		: 'auto',
			task		: "show_log",
			title		: XComLang.headers["viewLog"],

			onPopulate: function(form, data) {
				widget.html(data);
			}


		});

		event.preventDefault();

	});

});


/********************************
* Class to show 'content'-panel *
********************************/
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
				name: "id",
				label: "ID #",
				sortable: false,
				contents: this._id
			},
			{
				name: "error_no",
				label: "&nbsp;",
				sortable: false,
				contents: this._type
			},
			{
				name: "error_msg",
				label: "Event",
				sortable: false
			},
			{
				name: "time",
				label: "Date/Time",
				sortable: false
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
	},

	this._type = function(cell, item) {
		cell.addClass("cell-error_no type-" + item.error_no);
	},

	this._options = function(cell, item) {

		$("<img src='../images/cms/icons/view.png'>")
		.attr("title", XComLang.tips["view"])
		.click({id : item.id}, ViewPanel)
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


/*****************************
* Class to show 'edit'-panel *
*****************************/
function ViewPanel(event) {

	this.init = function(event) {

		$("#dvItem").panel({

			width		: 525,
			autoOpen	: true,
			type		: "view",
			id			: event.data.id,
			title		: XComLang.headers["viewEntry"],

		});

	},

	this.init(event);

}