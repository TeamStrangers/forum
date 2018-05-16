<?php

class PageDrawer
{
	static function getStyles()
	{
		$styles = '<link href="' . CDN_URL . '/stylesheets/menu.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/style.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/alertbox.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/loginwindow.css" type="text/css" rel="stylesheet" />';
		return $styles;
	}

	static function getScripts()
	{
		$scripts = '<script src="' . CDN_URL . '/scripts/jquery.js"></script>';
		$scripts .= '<script src="' . CDN_URL . '/scripts/menus.js" /></script>';
		return $scripts;
	}

	static function startPage()
	{
		echo '<!DOCTYPE html>';
		echo '<html>';
		echo '<head>';
		$translator = new Translator($_SESSION['language']);
		echo '<title>' . $translator->getString('title', array('pagename' => PAGENAME)) . '</title>';
		echo '<meta charset="UTF-8">';
		echo self::getStyles();
		echo '</head>';
		echo '<body>';
	}

	static function endPage()
	{
		echo '</body>';
		echo '</html>';
	}

	static function drawPage($page)
	{
		require SITE_LOCATION . '/config.php';
		$translator = new Translator($_SESSION['language']);
		self::startPage();

		//Draw the main menu on the top
		echo '<nav id="mainMenu"><div id="mainMenuContainer">';
		echo '<div id="mainMenuLogo">Logo</div>';
		echo '<div id="mainMenuLinks"><ul>';
		echo '<li><a href="index.php">Home</a></li>';
		echo '<li><a href="login.php">Login</a></li>';
		echo '</ul></div>';
		echo '<div id="mainMenuSearch"><input id="mainMenuSearchBar" type="text" placeholder="' . $translator->getString('search') . '"></div>';
		echo '</div>';
		echo '<div id="mainMenuUserPart">';
		//Draw language selection stuff
		echo '<div id="mainMenuUserPartLanguage">';
		foreach($valid_languages as $language)
		{
			echo '<img class="mainMenuUserPartLanguageIcon" data-language="' . $language . '" src="' . CDN_URL . '/images/flags/' . $language . '.png" />';
		}
		echo '</div>';
		//Draw welcome stuff or current user menu
		echo '<div id="mainMenuUserPartUser">';
		global $current_user;
		if($current_user != null)
		{
			echo $translator->getString('menuwelcome');
		}
		else
		{
			echo $translator->getString('menuawelcome');
		}
		echo '</div></div></nav>';

		//Draw the login and register window
		if($current_user == null)
		{
			echo '<div id="loginWindow"><div class="background"></div><div class="container">';
			echo '<div id="loginwindowtabs"><span id="loginwindowlefttab" onclick="selectLoginWindowTab(0)">' . $translator->getString('login') . '</span><span id="loginwindowrighttab" onclick="selectLoginWindowTab(1)">' . $translator->getString('register') . '</span></div>';
			//Login tab content
			echo '<div id="loginwindowtabcontent_login" style="display: none;">';
			echo '<form method="POST" action="../eventHandler/do_login.php"><input type="text" name="username" placeholder="Username"><br><input type="password" name="password" placeholder="Password"><br><input type="submit" value="Log In"></form>';
			echo '</div>';
			//Register tab content
			echo '<div id="loginwindowtabcontent_register" style="display: none;">';
			echo 'register';
			echo '</div>';
			echo '</div></div>';
		}

		// Draw the alertbox stuff
		echo '<div id="alertboxes">';
		if(isset($_GET['msg']) && !empty($_GET['msg']) && is_array($_GET['msg']) && array_key_exists(0, $_GET['msg']) && array_key_exists(1, $_GET['msg']))
		{
			$msg = $_GET['msg'];
			if($msg[0] == 'error')
			{
				echo '<div class="alertbox alertbox-red"><span onclick="this.parentElement.style.display=\'none\'">&times;</span><h2>' . $translator->getString('error') . '</h2><p>' . $msg[1] . '</p></div>';
			}
			else if($msg[0] == 'warn')
			{
				echo '<div class="alertbox alertbox-yellow"><span onclick="this.parentElement.style.display=\'none\'">&times;</span><h2>' . $translator->getString('warning') . '</h2><p>' . $msg[1] . '</p></div>';
			}
			else if($msg[0] == 'success')
			{
				echo '<div class="alertbox alertbox-green"><span onclick="this.parentElement.style.display=\'none\'">&times;</span><h2>' . $translator->getString('success') . '</h2><p>' . $msg[1] . '</p></div>';
			}
		}
		echo '</div>';

		//Draw the main body form the page
		echo '<div id="body">' . $page . '</div>';
		echo self::getScripts();
		self::endPage();
	}
}