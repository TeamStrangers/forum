var loginWindowShown = false;

$("#mainMenuLanguage img").on("click", function() {
	var language = $(this).attr("data-language");

	var options = {
		url: $(this).attr("data-changeurl") + "?language=" + language,
		type: "GET"
	};
	$.ajax(options).done(function() {
		location.reload();
	});
});

$("#loginWindow .background").on("click", function() {
    if(loginWindowShown == true)
    {
        loginWindowShown = false;
        document.getElementById('loginWindow').style.display = "none";
    }
});

$("#loginWindow #loginWindowCloseBtn").on("click", function() {
    if(loginWindowShown == true)
    {
        loginWindowShown = false;
        document.getElementById('loginWindow').style.display = "none";
    }
});

$(document).on("keyup", function(event) {
	if(event.which == 27)
	{
		if(loginWindowShown == true)
		{
			loginWindowShown = false;
			document.getElementById('loginWindow').style.display = "none";
		}
	}
});

$(document).ready(function() {

});

function showLoginDialog()
{
	selectLoginWindowTab(0);
	loginWindowShown = true;
	document.getElementById('loginWindow').style.display = "initial";
}

function showRegisterDialog()
{
	selectLoginWindowTab(1);
	loginWindowShown = true;
	document.getElementById('loginWindow').style.display = "initial";
}

function selectLoginWindowTab(tab)
{
	document.getElementById('loginwindowlefttab').classList.remove("loginwindowselectedtab");
	document.getElementById('loginwindowrighttab').classList.remove("loginwindowselectedtab");

	document.getElementById('fromsite').value = window.location.pathname;
	document.getElementById('fromsite2').value = window.location.pathname;

	document.getElementById('loginwindowtabcontent_login').style.display = 'none';
	document.getElementById('loginwindowtabcontent_register').style.display = 'none';
	if(tab == 0)
	{
		document.getElementById('loginwindowlefttab').classList.add("loginwindowselectedtab");
		document.getElementById('loginwindowtabcontent_login').style.display = 'initial';
	}
	else if(tab == 1)
	{
		document.getElementById('loginwindowrighttab').classList.add("loginwindowselectedtab");
		document.getElementById('loginwindowtabcontent_register').style.display = 'initial';
	}
}