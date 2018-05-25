<?php

session_start();

define('PAGENAME', "profile");

require '../config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);

$sqlid = (int) DatabaseHandler::escape_string($_GET['uid']);
$user = DatabaseHandler::getUserBySQLID($sqlid);
if($user != null)
{
	$page = $user->getUsername() . ' profile.';
}
else
{
	$page = 'User not found';
}

PageDrawer::drawPage($page);

DatabaseHandler::close();