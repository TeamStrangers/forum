<?php

class PageDrawer
{
	static function getStyles()
	{
		$styles = '<link href="' . CDN_URL . '/menu.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/style.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/alertbox.css" type="text/css" rel="stylesheet" />';
		return $styles;
	}

	static function getScripts()
	{
		$scripts = '<script src="' . CDN_URL . '/scripts/jquery.js"></script>';
		$scripts .= '<script src="' . CDN_URL . '/scripts/languageselector.js" /></script>';
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

		//<input type="text" placeholder="' . $translator->getString('search') . '">
		echo '<nav id="mainMenu"><div id="mainMenuContainer">';
		echo '<div id="mainMenuLogo">Logo</div>';
		echo '<div id="mainMenuLinks"><ul>';
		echo '<li><a href="index.php">Home</a></li>';
		echo '<li><a href="login.php">Login</a></li>';
		echo '</ul></div>';
		echo '<div id="mainMenuSearch"><input id="mainMenuSearchBar" type="text" placeholder="' . $translator->getString('search') . '"></div>';
		echo '</div><div id="mainMenuUserPart">';
		echo '<div id="mainMenuUserPartLanguage">';
		/*echo '<img class="mainMenuUserPartLanguageIcon" data-language="et" src="' . CDN_URL . '/images/flags/et.png" />';
		echo '<img class="mainMenuUserPartLanguageIcon" data-language="en" src="' . CDN_URL . '/images/flags/en.png" />';*/
		foreach($valid_languages as $language)
		{
			echo '<img class="mainMenuUserPartLanguageIcon" data-language="' . $language . '" src="' . CDN_URL . '/images/flags/' . $language . '.png" />';
		}
		echo '</div><div id="mainMenuUserPartUser">';
		global $current_user;
		if($current_user != null)
		{
			echo 'blaa';
		}
		else
		{
			echo $translator->getString('menuawelcome');
		}
		echo '</div></div></nav>';

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

		echo '<div id="body">' . $page . '</div>';
		echo self::getScripts();
		self::endPage();
	}
}