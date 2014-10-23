var CKEDITOR;

$(function() {

	new AddPanel();

	xConf.component = "adm_content";
	xConf.categoryList = new CategoryList({
		onLoad: function() {
			xConf.itemList = new ContentPanel().getList();
		}
	});

	CKEDITOR = CKEDITOR ? CKEDITOR : null;

	// Fixes issue #1
	$(document).on("focusin", function(e) {
		e.stopImmediatePropagation();
	});

});


function ContentPanel() {

	this.getList = function() {
		return this.list;
	};

	this._init = function() {

		this.list = $("#list");
		this.list.xlist({

			translations: true,
			columns: [
			{
				name: "xid",
				label: "ID #",
				sortable: true,
				contents: this._id
			},
			{
				name: "title",
				label: "Title",
				sortable: true
			},
			{
				name: "category",
				label: "Category",
				sortable: true,
				contents: this._category
			},
			{
				name: "published",
				label: "Published",
				sortable: true,
				contents: this._status
			},
			{
				name: "options",
				label: "&nbsp;",
				sortable: false,
				contents: this._options
			}

		]});

	};

	this._id = function(cell, item) {
		cell.text(Xirt.pad(item.xid, 6));
	};

	this._category = function(cell, item) {
		cell.text(xConf.categoryList.getCategory(item.category));
	};

	this._status = function(cell, item) {

		el = $("<img src='../images/cms/icons/published_" + item.published + ".png'>")
		.attr("title", XComLang.tips["status"])
		.click({id : item.id}, XAdmin.toggleStatus)
		.addClass("url tooltip")
		.appendTo(cell);

	};

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

		$("<img src='../images/cms/icons/config.png'>")
		.attr("title", XComLang.tips["config"])
		.click({id : item.id}, ConfigPanel)
		.addClass("url tooltip")
		.appendTo(cell);

		$("<img src='../images/cms/icons/access.png'>")
		.attr("title", XComLang.tips["access"])
		.click({id : item.id}, AccessPanel)
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


function CategoryList(options) {

	this._list = [];

	this.options = {
		onLoad : function() {}
	};

	this._init = function(options) {

		$.extend(true, this.options, options);
		this._load();

	};

	this._load = function() {

		$.ajax({

			url: "index.php",
			data: {
				content: xConf.component,
				task: "show_category_list",
				iso: xConf.language
			},

			error: Xirt.noAJAX,
			success: $.proxy(this._parseData, this)

		});

	};

	this._parseData = function(data) {

		this._list = data;
		this._update();
		this.options.onLoad(this._list);

	};

	this._update = function() {

		var widget = this;

		$.each(["#nx_category", "#x_category"], function(index, el) {

			$.each(widget._list, function(index, item) {

				var level = parseInt(item.level);
				var indent = Xirt.lead("- ", (level - 1) * 2);

				$("<option></option>")
				.text(indent + item.name)
				.val(item.xid)
				.appendTo($(el));

			});

		});

	};

	this.getCategory = function(id) {

		var category = "";

		$.each(this._list, function(index, item) {
			if (item.xid == id) {
				category = item.name;
			};
		});

		return category;

	};

	return this._init(options);

}


/****************************
* Class to show 'add'-panel *
****************************/
function AddPanel() {

	this.init = function() {

		var widget = $("#dvAdd").panel({

			type	: "add",
			title	: XComLang.headers["addContent"],

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

		var widget = this;

		this.hasEditor = !!CKEDITOR;
		this.rawEditor = this.hasEditor ? null : $("#x_content");
		this.jsEditor  = this.hasEditor ? CKEDITOR.instances.x_content : null;

		var panel = $("#dvItem").panel({

			type 		: "edit",
			autoOpen	: !this.hasEditor,
			id 			: event.data.id,
			width		: $(window).width() - 100,
			height		: $(window).height() - 50,
			title		: XComLang.headers["editContent"],

			close: function() {

				if (widget.hasEditor) {
					CKEDITOR.instances.x_content.destroy();
				}

			},

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

		// Initialize CKEditor
		if (this.hasEditor) {

			$.when($("#x_content").ckeditor($.extend(CKEDITOR.XirtConfig, {
				"width": $(window).width() - 575,
				"height": $(window).height() - 300
			})).promise).then(function() {
				panel.panel("open");
			});

		} else {
			
			this.rawEditor.css("height", $(window).height() - 160);
			this.rawEditor.css("width", $(window).width() - 600);
			
		}

		// Keep resizing dialog
		$(window).bind('resize.dialog', function(e) {

			$("#dvItem").panel("option", "width", $(window).width() - 50);
			$("#dvItem").panel("option", "height", $(window).height() - 50);

			if (widget.hasEditor) {

				CKEDITOR.instances.x_content.resize($(window).width() - 550, $(window).height() - 150);

			} else {

				widget.rawEditor.css("height", $(window).height() - 160);
				widget.rawEditor.css("width", $(window).width() - 600);

			}

		});

	};

	this.init(event);

}


/*******************************
* Class to show 'config'-panel *
*******************************/
function ConfigPanel(event) {

	this.init = function(event) {

		$("#dvConfig").panel({

			autoOpen	: true,
			type		: "edit",
			id			: event.data.id,
			task		: "show_details",
			title		: XComLang.headers["editConfig"],

			onPopulate: function(form, data) {
				Xirt.populateForm(form, data.config);
				form.find("[name=affect_all]").attr("checked", true);
			}

		});

	},

	this.init(event);

}


/*******************************
* Class to show 'access'-panel *
*******************************/
function AccessPanel(event) {

	this.init = function(event) {

		$("#dvAccess").panel({

			autoOpen	: true,
			type 		: "edit",
			id 			: event.data.id,
			title 		: XComLang.headers["editAccess"],

			onPopulate: function(form, data) {
				form.find("[name=affect_all]").attr("checked", true);
			},

			onSubmit: function() {

				$.jGrowl(XLang.messages["saved"]);
				xConf.itemList.xlist("load");
				this.close();

			}

		});

	},

	this.init(event);

}