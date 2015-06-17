$(function() {

	box = $("#x-feed");

	$.ajax({
		success: _parseData,
		error: Xirt.noConnection,
		url: "index.php",
		data: {
			content: "mod_twitterfeed",
			task: "show_twitter"
		}
	});

	function _parseData(data) {

		box.empty();
		$.each($.makeArray(data), function(index, tweet) {
			_showTweet(tweet, (index == data.length - 1));
		});

		_scroll($("div:first-child", box.scrollTop(0)));

	}

	function _showTweet(tweet, last) {

		var container = $("<div class='tweet'></div>")
		.addClass("tweet-" + tweet.id)
		.addClass(last ? "last" : "")
		.appendTo(box);

		var link = $("<a target='_blank' class='image'></a>")
		.attr("href", "http://www.twitter.com/" + tweet.account)
		.appendTo(container);

		$("<img src='" + tweet.avatar + "'></img>")
		.attr("alt", tweet.author)
		.appendTo(link);

		var content = $("<div class='tweet-content'></div>")
		.appendTo(container);

		$("<p class='tweet'></p>")
		.html(tweet.content)
		.appendTo( content);

		$("<span class='author'></span>")
		.text(tweet.author + " (" + tweet.created + ")")
		.appendTo(content);

	}

	function _scroll(el) {

		el = el.length ? el : $("div:first-child", box);

		box.animate({
			scrollTop: el.position().top + box.scrollTop()
		}, 1000);

		setTimeout(function() { _scroll($(el.next())); }, 3000);

	}

});
