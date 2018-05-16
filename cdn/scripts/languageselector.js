$(".mainMenuUserPartLanguageIcon").on("click", function() {
	var language = $(this).attr("data-language");

	var options = { url: "eventHandler/do_languageChange.php?language=" + language, type: "GET"};
	$.ajax(options).done(function() {
		location.reload();
	});
});