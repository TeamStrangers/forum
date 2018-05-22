<?php

class PageDrawer
{
	static function getStyles()
	{
		$styles = '<link href="' . CDN_URL . '/stylesheets/menu.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/style.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/alertbox.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/loginwindow.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/fontawesome/fontawesome-all.min.css" rel="stylesheet" />';
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
		echo '<title>' . $translator->getString('title', array('pagename' => $translator->getString(PAGENAME))) . '</title>';
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

		global $current_user;

		//Draw the main menu on the top
		echo '<nav id="mainMenu">';
		echo '<img id="mainMenuLogo" src="' . CDN_URL . '/images/logo.png" alt="Logo" />';
		echo '<ul id="mainMenuLinks">';
		echo '<li><a href="index.php">Home</a></li>';
		echo '<li><a href="index.php">Trending</a></li>';
		echo '<li><a href="index.php">Most Recent</a></li>';
		echo '</ul>';

		echo '<div style="display: inline; float: right;">';

		echo '<div id="mainMenuLanguage">';
		global $valid_languages;
		foreach($valid_languages as $language)
		{
			echo '<img data-language="' . $language . '" src="' . CDN_URL . '/images/flags/' . $language . '.png" title="' . Translator::getLanguageName($language) . '" />';
		}
		echo '</div>';

		echo '<div id="mainMenuSearch"><button><i class="fa-stack"><i class="fa fa-search fa-stack-1x"></i><i class="far fa-square fa-stack-2x"></i></i></button><input name="search" type="search" placeholder="' . $translator->getString("search") . '" /></div>';

		if($current_user != null)
		{
			echo '<div id="mainMenuNotification"><button><i class="fa-stack"><i class="fa fa-bell fa-stack-1x"></i><i class="far fa-square fa-stack-2x"></i></i></button><div></div></div>';
			echo '<div id="mainMenuUser"><span>' . $current_user->getUsername() . '</span><img src="' . $current_user->getAvatar() . '" alt="Avatar"/></div>';
		}
		else
		{
			echo '<div id="mainMenuUser"><a onclick="showLoginDialog()">' . $translator->getString('login') . '</a></div>';
		}
		echo '</div>';

		/*echo '<div id="mainMenuUserPart">';
		//Draw language selection stuff
		echo '<div id="mainMenuUserPartLanguage">';
		global $valid_languages;
		foreach($valid_languages as $language)
		{
			echo '<img class="mainMenuUserPartLanguageIcon" data-language="' . $language . '" src="' . CDN_URL . '/images/flags/' . $language . '.png" title="' . Translator::getLanguageName($language) . '" />';
		}
		echo '</div>';
		//Draw welcome stuff or current user menu
		global $current_user;
		if($current_user != null)
		{
			echo '<div id="mainMenuUserPartUser">';
			echo '<span>' .  $current_user->getUsername(). '</span>';
			echo '<img src="' .  $current_user->getAvatar(). '" />';
			echo '<ul>';
			echo '<li><a href="' . SITE_URL . '/eventHandler/do_logout.php">' . $translator->getString('logout') . '</a></li>';
			echo '</ul>';
			echo '</div>';
		}
		else
		{
			echo '<div id="mainMenuUserPartUser">';
			$loginlink = '<a onclick="showLoginDialog()" class="mainMenuUserPartLink">' . $translator->getString('login') . '</a>';
			$registerlink = '<a onclick="showRegisterDialog()" class="mainMenuUserPartLink">' . $translator->getString('register') . '</a>';
			echo $translator->getString('menuawelcome', array('loginlink' => $loginlink, 'registerlink' => $registerlink));
			echo '</div>';
		}*/
		echo '</nav>';

		//Draw the login and register window
		if($current_user == null)
		{
			echo '<div id="loginWindow"><div class="background"></div><div class="container">';
			echo '<div id="loginwindowtabs"><span id="loginwindowlefttab" onclick="selectLoginWindowTab(0)">' . $translator->getString('login') . '</span><span id="loginwindowrighttab" onclick="selectLoginWindowTab(1)">' . $translator->getString('register') . '</span></div>';
			//Login tab content
			echo '<div id="loginwindowtabcontent_login" style="display: none;">';
			echo '<form method="POST" action="' . SITE_URL . '/eventHandler/do_login.php"><input type="text" name="username" placeholder="' . $translator->getString('userename') . '"><br><input type="password" name="password" placeholder="' . $translator->getString('password') . '"><input type="hidden" name="fromsite" id="fromsite"><br><input type="submit" value="' . $translator->getString('login') . '"></form>';
			echo '</div>';
			//Register tab content
			echo '<div id="loginwindowtabcontent_register" style="display: none;">';
			echo '<form method="POST" action="' . SITE_URL . '/eventHandler/do_register.php"><input type="text" name="username" placeholder="' . $translator->getString('username') . '"><br><input type="email" name="email" placeholder="' . $translator->getString('email') . '"><br><input type="password" name="password" placeholder="' . $translator->getString('password') . '"><br><input type="password" name="password2" placeholder="' . $translator->getString('password2') . '"><input type="hidden" name="fromsite" id="fromsite2"><br><input type="submit" value="' . $translator->getString('register') . '"></form>';
			echo '</div>';
			echo '</div></div>';
		}

		// Draw the alertbox stuff TODO: Remove the dammn alertboxes one day!
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
		echo '<div id="sidebar"><ul>';
		if($current_user != null)
		{
			//echo '<li><a href="' . SITE_URL . '/eventHandler/do_logout.php">Profile</a></li>';
			echo '<li><a href="' . SITE_URL . '/eventHandler/do_logout.php">' . $translator->getString('logout') . '</a></li>';
		}
		echo '</ul></div>';

		echo '<div id="body">' . $page . '</div>';
		echo self::getScripts();
		self::endPage();
	}
}