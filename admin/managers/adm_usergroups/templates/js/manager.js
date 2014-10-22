$(function() {

	new AddPanel();
	xConf.component = "adm_usergroups";
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
				name: "rank",
				label: XComLang.columns["rank"],
				sortable: true
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

	this._options = function(cell, item, widget) {

		if (parseInt(item.translation)) {

			$("<img src='../images/cms/icons/new.png'>")
			.click({xid : item.rank}, XAdmin.translate)
			.attr("title", XComLang.tips["translate"])
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
			title	: XComLang.headers["addUsergroup"],

			onPopulate: function(form, data) {
				form.find('[name=nx_language]').val(xConf.language);
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
			title		: XComLang.headers["editUsergroup"],

			onPopulate: function(form, data) {
				form.find("[name=xid]").val(data.rank);
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

	this.init(event);

}