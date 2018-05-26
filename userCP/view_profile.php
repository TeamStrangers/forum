<?php

session_start();

define('PAGENAME', "profile");
define('THIS_SCRIPT', 'view_profile');

require '../config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);

$sqlid = (int) DatabaseHandler::escape_string($_GET['uid']);
$user = DatabaseHandler::getUserBySQLID($sqlid);
if($user != null)
{
	define('CUSTOM_TITLE', $translator->getString('title', array('pagename' => $user->getUsername() . ' ' . $translator->getString('profile'))));
	$page = $user->getUsername() . ' profile.';
}
else
{
	$page = 'User not found';
}

PageDrawer::drawPage($page);

DatabaseHandler::close();