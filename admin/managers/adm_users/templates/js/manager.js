$(function() {

	new AddPanel();
	xConf.component = "adm_users";
	xConf.itemList = new ContentPanel().getList();

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

			columns: [
			{
				name: "id",
				label: XComLang.columns["id"],
				sortable: true,
				contents: this._id
			},
			{
				name: "rank",
				label: XComLang.columns["rank"],
				sortable: true
			},
			{
				name: "username",
				label: XComLang.columns["username"],
				sortable: true
			},
			{
				name: "name",
				label: XComLang.columns["name"],
				sortable: true
			},
			{
				name: "mail",
				label: XComLang.columns["mail"],
				sortable: true
			},
			{
				name: "dt_joined",
				label: XComLang.columns["dt_joined"],
				sortable: true
			},
			{
				name: "dt_login",
				label: XComLang.columns["dt_login"],
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

	this._options = function(cell, item) {

		$("<img src='../images/cms/icons/edit.png'>")
		.attr("title", XComLang.tips["edit"])
		.click({id : item.id}, EditPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		$("<img src='../images/cms/icons/password.png'>")
		.attr("title", XComLang.tips["password"])
		.click({id : item.id}, PasswordPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		var opacity = parseInt(item.login_attempts) ? 1 : 0.25;
		$("<img src='../images/cms/icons/count.png'>")
		.attr("title", XComLang.tips["unlock"])
		.click({id : item.id}, ResetPanel)
		.addClass("url tooltip")
		.fadeTo(0, opacity)
		.appendTo(cell);

		var opacity = Math.min(item.id - 0.75, 1);
		$("<img src='../images/cms/icons/remove.png'>")
		.attr("title", XComLang.tips["remove"])
		.click({id : item.id}, XAdmin.remove)
		.addClass("url tooltip")
		.fadeTo(0, opacity)
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
			title	: XComLang.headers["addUser"],

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


/*****************************
* Class to show 'edit'-panel *
*****************************/
function EditPanel(event) {

	this.init = function(event) {

		$("#dvItem").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["editUser"],

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


/*********************************
* Class to show 'password'-panel *
*********************************/
function PasswordPanel(event) {

	this.init = function(event) {

		$("#dvPassword").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			title		: XComLang.headers["resetPassword"],

			onSubmit: function(out) {

				$.jGrowl(out);
				this.close();

			}

		});

		var el = $("#pwform");
		$("#pwtoggle").click(function() {
			$(this).is(":checked") ? el.hide() : el.show();
		});

	},

	this.init(event);

}


/******************************
* Class to show 'reset'-panel *
******************************/
function ResetPanel (event) {

	new confirmation({

		message: XComLang.confirmations["reset"],
		onConfirm: function() {

			$.ajax({

				url: "index.php",
				data: {
					content: xConf.component,
					task: "reset_lock",
					id: event.data.id
				},
				error: Xirt.noAJAX,

				success: function(out) {

					xConf.itemList.xlist("load");
					$.jGrowl(out);

				}

			});

		}

	});

}