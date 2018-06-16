<?php

class PageDrawer
{
	static $redirectedToIndex = false;

	static function redirectToIndex()
	{
		self::$redirectedToIndex = true;
		header('Location: ' . SITE_URL . '/index.php');
	}

	static function redirectTo($url)
	{
		self::$redirectedToIndex = true;
		header('Location: ' . SITE_URL . $url);
	}

	static function getStyles()
	{
		$styles = '<link href="' . CDN_URL . '/stylesheets/menu.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/style.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/forms.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/loginwindow.css" type="text/css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/fontawesome/fontawesome-all.min.css" rel="stylesheet" />';
		$styles .= '<link href="' . CDN_URL . '/stylesheets/pages/' . THIS_SCRIPT . '.css" rel="stylesheet" />';
		return $styles;
	}

	static function getScripts()
	{
		$scripts = '<script src="' . CDN_URL . '/scripts/jquery.js"></script>';
		$scripts .= '<script src="' . CDN_URL . '/scripts/menus.js" /></script>';
		$scripts .= '<script src="' . CDN_URL . '/scripts/pages/' . THIS_SCRIPT . '.js" /></script>';
		return $scripts;
	}

	static function startPage()
	{
		echo '<!DOCTYPE html>';
		echo '<html>';
		echo '<head>';
		$translator = new Translator($_SESSION['language']);
		if(!defined('CUSTOM_TITLE')) echo '<title>' . $translator->getString('title', array('pagename' => $translator->getString(PAGENAME))) . '</title>';
		else { echo '<title>' . CUSTOM_TITLE . '</title>'; }
		echo '<meta charset="UTF-8">';
		echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
		echo self::getStyles();
		echo '</head>';
		echo '<body>';
	}

	static function endPage()
	{
		echo '</body>';
		echo '</html>';
	}

	static function drawPage($page, $additions = null)
	{
		if(self::$redirectedToIndex == false)
		{
			require SITE_LOCATION.'/config.php';
			$translator = new Translator($_SESSION['language']);
			self::startPage();

			global $current_user;

			//Draw the main menu on the top
			echo '<nav id="mainMenu">';
			echo '<img id="mainMenuLogo" src="'.CDN_URL.'/images/logo.png" alt="Logo" />';
			echo '<ul id="mainMenuLinks">';
			echo '<li><a href="'.SITE_URL.'/index.php">'.$translator->getString('title_home').'</a></li>';
			echo '<li><a href="'.SITE_URL.'/trending.php">'.$translator->getString('title_trending').'</a></li>';
			echo '<li><a href="'.SITE_URL.'/recent.php">'.$translator->getString('title_mostrecent').'</a></li>';
			echo '</ul>';

			echo '<div style="display: inline; float: right;">';

			echo '<div id="mainMenuLanguage">';
			global $valid_languages;
			foreach($valid_languages as $language)
			{
				echo '<img data-language="'.$language.'" data-changeurl="'.SITE_URL.'/eventHandler/do_languageChange.php" src="'.CDN_URL.'/images/flags/'.$language.'.png" title="'.Translator::getLanguageName($language).'" />';
			}
			echo '</div>';

			echo '<div id="mainMenuSearch"><form action="search.php" method="get"><input name="search" type="text" placeholder="'.$translator->getString("search").'" /><button type="submit"><i class="fa fa-search"></i></button></form></div>';

			if($current_user != null)
			{
				echo '<div id="mainMenuNotification"><button><i class="fa fa-bell"><span class="badge"></span></i></button><div></div></div>';
				echo '<div id="mainMenuUser"><span>'.$current_user->getUsername().'</span><img src="'.$current_user->getAvatar().'" alt="Avatar"/></div>';
			} else
			{
				echo '<div id="mainMenuUser"><a onclick="showLoginDialog()">'.$translator->getString('login').'</a><a onclick="showRegisterDialog()">'.$translator->getString('register').'</a></div>';
			}
			echo '</div>';

			echo '</nav>';

			//Draw the login and register window
			if($current_user == null)
			{
				echo '<div id="loginWindow"><div class="background"></div><div class="container">';
				echo '<span id="loginWindowCloseBtn">&times;</span>';
				//Login tab content
				echo '<div id="loginWindowTabContent">';
				echo '<div id="loginwindowtabcontent_login" style="display: none;">';
				echo '<form method="POST" action="'.SITE_URL.'/eventHandler/do_login.php"><input type="text" name="username" placeholder="'.$translator->getString('userename').'"><br><input type="password" name="password" placeholder="'.$translator->getString('password').'"><input type="hidden" name="fromsite" id="fromsite"><br><input type="submit" value="'.$translator->getString('login').'"></form>';
				echo '</div>';
				//Register tab content
				echo '<div id="loginwindowtabcontent_register" style="display: none;">';
				echo '<form method="POST" action="'.SITE_URL.'/eventHandler/do_register.php" data-validator="' . SITE_URL . '/eventHandler/check_userStatus.php"><input type="text" name="username" placeholder="'.$translator->getString('username').'"><br><input type="email" name="email" placeholder="'.$translator->getString('email').'"><br><input type="password" name="password" placeholder="'.$translator->getString('password').'"><br><input type="password" name="password2" placeholder="'.$translator->getString('password2').'"><input type="hidden" name="fromsite" id="fromsite2"><br><input type="submit" value="'.$translator->getString('register').'"><br><span class="errorMsg" id="registerErrorMessage1"></span><br><span class="errorMsg" id="registerErrorMessage2"></span></form>';
				echo '</div>';
				echo '</div>';
				//Tabs
				echo '<div id="loginwindowtabs"><span id="loginwindowlefttab" onclick="selectLoginWindowTab(0)">'.$translator->getString('login').'</span><span id="loginwindowrighttab" onclick="selectLoginWindowTab(1)">'.$translator->getString('register').'</span></div>';
				echo '</div></div>';
			}

			//Draw the main body form the page
			echo '<div id="sidebar">';
			echo '<ul>';
			if($current_user != null)
			{
				echo '<li><a href="'.SITE_URL.'/userCP/view_profile.php?uid='.$current_user->getSQLID().'">'.$translator->getString('profile').'</a></li>';
				echo '<li><a href="'.SITE_URL.'/userCP/usercp.php">'.$translator->getString('account_settings').'</a></li>';
				echo '<li><a href="'.SITE_URL.'/eventHandler/do_logout.php?fromsite=' . $_SERVER['REQUEST_URI'] . '">'.$translator->getString('logout').'</a></li>';
			}
			echo '</ul>';

			if($additions != null)
			{
				if(is_array($additions))
				{
					for($i = 0; $i <= 10; $i++)
					{
						if(array_key_exists('custom_menu' . $i, $additions))
						{
							echo '<ul>';
							foreach ($additions['custom_menu' . $i] as $name => $url)
							{
								echo '<li><a href="' . SITE_URL . $url . '">' . $name . '</a></li>';
							}
							echo '</ul>';
						}
					}
				}
			}
			echo '</div>';

			echo '<div id="body">'.$page.'</div>';
			echo self::getScripts();
			self::endPage();
		}
	}
}