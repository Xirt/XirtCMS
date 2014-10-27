var xConf = xConf ? xConf : {};
xConf.admin = true;

/*********************************************************
*      XADMIN - Utility Library for XirtCMS Admin        *
*              (version 2.0 - 19.01.2014)                *
**********************************************************/
var XAdmin = {

	// Toggle 'published'-status of item (12.01.2014)
	toggleStatus: function (event) {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "toggle_status",
				xid: event.data.xid,
				id: event.data.id
			},

			error: Xirt.noAJAX,
			success: function(out) {
				out ? $.jGrowl(out) : xConf.itemList.xlist("load");
			}

		});

	},


	// Toggle 'active'-status of item (12.01.2014)
	toggleActive: function (event) {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "toggle_active",
				xid: event.data.xid,
				id: event.data.id
			},

			error: Xirt.noAJAX,
			success: function(out) {
				out ? $.jGrowl(out) : xConf.itemList.xlist("load");
			}

		});

	},


	// Toggle 'sitemap'-status of item (19.01.2014)
	toggleSitemap: function (event) {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "toggle_sitemap",
				id: event.data.id
			},

			error: Xirt.noAJAX,
			success: function(out) {
				out ? $.jGrowl(out) : xConf.itemList.xlist("load");
			}

		});

	},


	// Toggle 'mobile'-status of item (19.01.2014)
	toggleMobile: function (event) {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "toggle_mobile",
				xid: event.data.xid,
				id: event.data.id
			},

			error: Xirt.noAJAX,
			success: function(out) {
				out ? $.jGrowl(out) : xConf.itemList.xlist("load");
			}

		});

	},


	// Move item up the list (14.01.2014)
	moveUp: function (event) {

		if ((el = $(this).parents("tr")) && !el.prev().size()) {
			return el.effect("highlight", { color : "#ff7979" });
		}

		$.ajax({

			url: "index.php",
			error: Xirt.noAJAX,
			data: {
				content: xConf.component,
				task: "move_up",
				xid: event.data.xid,
				id: event.data.id
			}

		});

		el.after(el.prev());

	},


	// Move item down the list (14.01.2014)
	moveDown: function (event) {

		if ((el = $(this).parents("tr")) && !el.next().size()) {
			return el.effect("highlight", { color : "#ff7979" });
		}

		$.ajax({

			url: "index.php",
			error: Xirt.noAJAX,
			data: {
				content: xConf.component,
				task: "move_down",
				xid: event.data.xid,
				id: event.data.id
			}

		});

		el.before(el.next());

	},


	// Translate an item (12.01.2014)
	translate: function (event) {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "add_translation",
				language: xConf.language,
				xid: event.data.xid
			},

			error: Xirt.noAJAX,
			success: function(out) {
				out ? $.jGrowl(out) : xConf.itemList.xlist("load");
			}

		});

	},


	// Remove an item (12.01.2014)
	remove: function (event) {

		new confirmation({

			message: XLang.confirmations["remove"],
			onConfirm: function() {

				$.ajax({

					url: "index.php",
					data: {
						content: xConf.component,
						task: "remove_item",
						xid: event.data.xid,
						id: event.data.id
					},

					error: Xirt.noAJAX,
					success: function(out) {
						out ? $.jGrowl(out) : xConf.itemList.xlist("load");
					}

				});

			}

		});

	}

};


/*********************************************************
*           UI.PANEL - Standard XirtCMS Panel            *
*              (version 2.0 - 12.01.2014)                *
**********************************************************/
$.widget("ui.panel", $.extend(true, {}, $.ui.dialog.prototype, {

	options: {

		dialogClass: "no-close",
		initialized: false,
		draggable: false,
		resizable: false,
		autoOpen: false,
		maxHeight: 500,
		minHeight: 0,
		show: "fade",
		hide: "fade",
		modal: true,
		width: 450,
		id: 0,
		type: "normal",
		task: "show_item",

		buttons: [{

			text: "Close",
			click: function() {

				$("#" + this.id + " form :input").each(function(i, el) {
					if ($(el).data("uiTooltip")) $(el).tooltip("close");
				});

				$(this).panel("close");

			}

		}],

		position: {
			my: "center top+25",
			at: "center top",
			of: window,
			collision: "fit",
		},

		open: function(event, ui) {

			var widget = $(this).data("uiPanel");
			var type = widget.options.type;

			if (type != "edit" && type != "view") {
				$(event.target).find("form").reset();
			}

			widget.options.onOpen($(event.target).find("form"));
		},

		onOpen: function(form) {
		},

		onPopulate: function(form, data) {
		},

		onValidate: function(form, data) {
		},

		onSubmit: function(out) {

			if (out && out.length) {
				return $.jGrowl(out);
			}

			$.jGrowl(XLang.messages["success"]);
			this.close();

		}

	},

	_init: function() {

		var container = this;

		if (!this.option("initialized")) {

			Form.Validate(container.uiDialog.find("form"), {

				onSuccess: function(form) {

					container.options.onValidate(form);

					new Form.Request(form, {
						onSuccess: $.proxy(container.options.onSubmit, container)
					});

				}

			});

			this._buttons();
		}

		this.option("initialized", true);
		if (this.options.type == "edit" || this.options.type == "view") {
			this._load();
		}

	},

	_buttons: function() {

		switch (this.options.type) {

			case "add":
			case "edit":

				this.option("buttons", $.merge([{
					text: XLang.misc["save"],
					click: function() {
						$("#" + this.id + " form").submit();
					}
				}], this.options.buttons));

		}

	},

	_load: function() {

		$.ajax({
			context: this,
			success: this._parseData,
			error: Xirt.noAJAX,
			url: "index.php",
			data: {
				content: xConf.component,
				task: this.options.task,
				id: this.options.id
			}
		});

	},

	_parseData: function(json) {

		try {

			var form = $(this.uiDialog.find("form"));
			if (typeof json == "object") {
				Xirt.populateForm(form, json);
			}

		} catch (e) {

			// Nothing to do apparently

		} finally {

			this.options.onPopulate(form, json);
			if (this.options.autoOpen) {
				this.open();
			}

		}

	}

}));


/*********************************************************
*  UI.LANGUAGEPANEL - Standard Language Selection Panel  *
*              (version 2.0 - 04.01.2014)                *
**********************************************************/
$.widget("ui.languagepanel", {

	options: {
		onChange : function() {},
		onClose  : function() {},
		onLoad   : function() {},
		onOpen   : function() {}
	},

	_create: function() {

		this.element = $("<table>");
		this.element.dialog({
			modal: true,
			show: "fade",
			hide: "fade",
			width: "auto",
			autoOpen: false,
			dialogClass: "no-close no-header"
		}).addClass("xlist-table-language");

		$.ajax({
			context: this,
			success: this._parseData,
			error: Xirt.noAJAX,
			url: "../index.php",
			data: {
				content: "com_helper",
				task: "show_languages"
			}
		});

	},

	_parseData: function(data) {

		var counter = 0;
		var widget = this;
		var len = $.map(data, function(n, i) { return i; }).length;

		$.each(data, function(iso, language) {

			if (!counter) {
				widget.setLanguage($.cookie("xirt.language") ? $.cookie("xirt.language") : iso);
			}

			if (len < 10 || counter % 2 == 0) {
				row = $("<tr>").appendTo(widget.element);
			}

			var cell = $("<td>").appendTo(row).click(function(e) {
				widget.setLanguage(iso);
				widget.close();
			});

			$("<img src='../images/cms/flags/" + iso + ".png' />").appendTo(cell);
			$("<label>" + language.name + "</label>").appendTo(cell);

			counter++;
		});

		this.options.onLoad();
	},

	open: function(parent) {

		if (parent) {

			this.element.dialog( "option", "position", {
				my: "left top",
				at: "right+5 top",
				of: parent
			});

		}

		this.element.dialog("open");
		this.options.onOpen();

	},

	close: function() {

		this.element.dialog("close");
		this.options.onClose();

	},

	setLanguage: function(iso) {

		xConf.language = iso;
		this.options.onChange(iso);
		$.cookie("xirt.language", iso);

	}

});