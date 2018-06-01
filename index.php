<?php

session_start();

define('PAGENAME', "title_home");
define('THIS_SCRIPT', 'index');

require 'config.php';

DatabaseHandler::connect();

$translator = new Translator($_SESSION['language']);
$page = '';
global $current_user;




if($current_user != null)
{
	$categories = DatabaseHandler::getBaseCategories();
	foreach($categories as $category)
	{
		$page .= $category->getName() . '<br>';
	}
}
else
{
	$page .= 'Home';
}




PageDrawer::drawPage($page);

DatabaseHandler::close();