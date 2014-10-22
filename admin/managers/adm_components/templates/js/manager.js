$(function() {

	xConf.component = "adm_components";
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
				name: "id",
				label: XComLang.columns["id"],
				sortable: true,
				contents: this._id
			},
			{
				name: "name",
				label: XComLang.columns["name"],
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
		cell.text(Xirt.pad(item.id));
	},

	this._options = function(cell, item, widget) {

		if (parseInt(item.id) > 1) {

			$("<img src='../images/cms/icons/access.png'>")
			.attr("title", XComLang.tips["access"])
			.click({id : item.id}, AccessPanel)
			.addClass("url tooltip")
			.appendTo(cell);

		}

	};

	return this._init();

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

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this.init(event);

}